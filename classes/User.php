<?php


class User
{
    private $_db;
    private $_data;
    private $_sessionName;
    private $_cookieName;
    private $_isLoggedIn;
    private $_failedAttemptsData = null;
    private $_allUsers;


    public function __construct($user = null)
    {
        $this->_db = DB::getInstance();

        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');

        if (!$user) {
            if (Session::exists($this->_sessionName)) {
                $user = Session::get($this->_sessionName);

                if ($this->find($user)) {
                    $this->_isLoggedIn = true;
                } else {
                    // process logout
                }
            }
        } else {
            $this->find($user);
            $loginAttempts = $this->_db->get('login_attempts', array('user_id', '=', $this->data()->id))->results();
            if ($loginAttempts) {
                $this->_failedAttemptsData = $this->_db->get('login_attempts', array('user_id', '=', $this->data()->id))->first();
            }
        }
    }

    public function update($fields = array(), $id = null)
    {

        if (!$id && $this->isLoggedIn()) {
            $id = $this->data()->id;
        }

        if (!$this->_db->update('users', $id, $fields)) {
            throw new Exception('There was a problem updating');
        }
    }


    public function create($fields = array())
    {
        if (!$this->_db->insert('users', $fields)) {
            throw new Exception('There was a problem creating an account.');
        }


    }


    public function register()
    {

        $emailCode = md5(uniqid(rand()));
        $userEmail = Input::get('email');
        $id = hexdec(substr(sha1($userEmail), 0, 5));
        $username = Input::get('username');


        $message = "
                        Hello $username,
                        <br /><br />
                        Welcome to Coding Cage!<br/>
                        To complete your registration  please , just click following link<br/>
                        <br /><br />
                        <a href='http://localhost/2ndSemV2/ws-project/confirm.php?id=$id&code=$emailCode'> Click HERE to Activate your account :)</a>
                        <br /><br />
                        Thanks,
                     ";

        try {
            $this->create(array(
                'id' => $id,
                'username' => Input::get('username'),
                'email' => Input::get('email'),
                'password' => Hash::make(Input::get('password')),
                'firstname' => Input::get('firstname'),
                'lastname' => Input::get('lastname'),
                'joined' => date('Y-m-d H:i:s'),
                'rights' => 1,
                'email_confirmation' => 0,
                'activation_code' => $emailCode
            ));

            $this->send_mail($userEmail, $message, 'B-storage account activation');


            Session::flash('home', 'Check your email to activate your account.');
            // Redirect::to(404);
            Redirect::to('index.php');

            return true;

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }


    public function find($user = null)
    {
        if ($user) {
            # check if the user exists get data and store it in a private property
            $field = (is_numeric($user)) ? 'id' : 'username';
            $data = $this->_db->get('users', array($field, '=', $user));


            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }


    public function login($username = null, $password = null, $remember = false)
    {

        // log in the user and set a session if he has a hash
        if (!$username && !$password && $this->exists()) {

            Session::put($this->_sessionName, $this->data()->id);

        } else {
            $user = $this->find($username);

            if ($user && $this->data()->email_confirmation != 0) {

                if (password_verify($password, $this->data()->password)) {
                    Session::put($this->_sessionName, $this->data()->id);

                    // if user logged in then delete failed login attempts
//                    $this->loginAttempts($this->data()->id, false);

                    $this->deleteFailedAttempts();

                    if ($remember) {
                        $hash = Hash::unique();
                        $hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));

                        if (!$hashCheck->count()) {
                            $this->_db->insert('users_session', array(
                                'user_id' => $this->data()->id,
                                'hash' => $hash
                            ));
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }

                        Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                    }

                    return true;
                } else {
                    if ($this->checkAttempts() == false){
                        $this->addFailedAttempt();
                    }else{
                        $this->processFailedAttempts();
                    }
                }


            } else {
                $this->addHackerAttempt($username);

                Session::flash('home', 'Username or password incorrect.');
                // Redirect::to(404);
                Redirect::to('index.php');
            }

        }
        return false;
    }


    public function processFailedAttempts()
    {
        $loginAttempts = $this->_db->get('login_attempts', array('user_id', '=', $this->data()->id))->first();
        $userAttempts = $loginAttempts->attempts;
        $userAttempts = $userAttempts + 1;

        $this->_db->update('login_attempts', $loginAttempts->id, array('attempts' => $userAttempts));

        if ($userAttempts == 5) {
            //  create function to block user from logging in after 3 failures
            $this->deactivateAccount($loginAttempts->user_id);

            $emailCode = md5(uniqid(rand()));
            $userEmail = $this->data()->email;
            $id = hexdec(substr(sha1($userEmail), 0, 5));
            $username = $this->data()->username;
            $userId = $this->data()->id;

            $this->_db->update('users', $userId, array('activation_code' => $emailCode));

            $message = "
                        Hello $username,
                        <br /><br />
                        Welcome to Coding Cage!<br/>
                        To complete your registration  please , just click following link<br/>
                        <br /><br />
                        <a href='http://localhost/2ndSemV2/ws-project/confirm.php?id=$id&code=$emailCode'> Click HERE to Activate your account :)</a>
                        <br /><br />
                        Thanks,
                     ";

            $this->send_mail($userEmail, $message, 'B-storage account activation');


            Session::flash('home', 'TOO MANY ATTEMPTS! A PASSWORD RESET EMAIL HAS BEEN SENT!');
            // Redirect::to(404);
            Redirect::to('index.php');

            return true;


        }

//        if ($userAttempts < 3) {
//
//        }

    }

    public function addFailedAttempt()
    {
        $this->_db->insert('login_attempts', array(
            'email' => $this->data()->email,
            'username' => $this->data()->username,
            'user_id' => $this->data()->id,
            'last_attempt' => date('Y-m-d H:i:s'),
            'attempts' => 1

        ));

    }


    public function addHackerAttempt($username){

        $this->_db->insert('login_attempts', array(
            'email' => 'hacker',
            'username' => $username,
            'user_id' => rand(0, 333333),
            'last_attempt' => date('Y-m-d H:i:s'),
            'attempts' => 1

        ));
    }

    public function checkAttempts()
    {
        $loginAttempts = $this->_db->get('login_attempts', array('username', '=', $this->data()->username));
        if (!$loginAttempts->count()) {
            return false;
        } else {
//            $userLoginAttempts = $loginAttempts->first();
//            $userLoginAttempts->attempts;
            return true;
//            die($userLoginAttempts->attempts);
        }
    }

    public function deleteFailedAttempts()
    {
        $last_attempt = $this->failedAttemptsData()->last_attempt;

        if ((time() - strtotime($last_attempt)) > 300) {
            $this->_db->delete('login_attempts', array(
                'user_id', '=', $this->data()->id
            ));
        }

    }

    public function activateAccount($userId, $confirmationCode)
    {

        $this->find($userId);

        if ($this->data()->activation_code == $confirmationCode) {
            try {
                $this->update(array('email_confirmation' => 1), $userId);

                return true;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function deactivateAccount($userId){
        $this->find($userId);
        try {
            $this->update(array('email_confirmation' => 0), $userId);

            return true;
        } catch (Exception $e) {
            die($e->getMessage());
        }

    }


    public function send_mail($email, $message, $subject)
    {

        require("PHPMailer_5.2.0/class.phpmailer.php");

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug = 2;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Host = "smtp.gmail.com";
        $mail->Mailer = "smtp";
        $mail->Port = 587;
        $mail->Username = "plm.b.storage@gmail.com";
        $mail->Password = "PlmBananaStorage";

        $mail->From = "plm.b.storage@gmail.com";
        $mail->FromName = "B-storage";

        $mail->AddAddress($email);       // name is optional


        $mail->WordWrap = 50;                                 // set word wrap to 50 characters
        $mail->IsHTML(true);                                  // set email format to HTML

        $mail->Subject = $subject;
        $mail->Body = $message;  //"Click <a href=http://188.226.141.170/controller/confirm.php?et=".$emailToken.">here</a> to activate your AirQuick account!";
        $mail->AltBody = $message;  //"Go to the link below to activate your AirQuick account http://188.226.141.170/controller/confirm.php?et=".$emailToken;

        $mail->Send();


    }

    /**
     * @return mixed
     */
    public function getAllUsers()
    {
        $allUsers = $this->_db->query('SELECT * FROM users');
        $this->_allUsers = $allUsers->results();
        return $this->_allUsers;
    }


    public function exists()
    {
        return (!empty($this->_data)) ? true : false;
    }


    public function logout()
    {
        $this->_db->delete('users_session', array('user_id', '=', $this->data()->id));

        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
    }

    public function data()
    {
        return $this->_data;
    }


    public function isLoggedIn()
    {
        return $this->_isLoggedIn;
    }

    public function failedAttemptsData()
    {
        return $this->_failedAttemptsData;
    }

}
