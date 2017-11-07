<?php

require_once 'core/init.php';

// var_dump(Token::check(Input::get('token')));

if (Input::exists()) {
    // echo Input::get('username');
    if (Token::check(Input::get('token'))) {
        echo 'Ive been run <br> ';

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
      'username' => array(
        'required' => true,
        'min' => 2,
        'max' => 20,
        'unique' => 'users'
      ),
      'password' => array(
        'required' => true,
        'min' => 8
      ),
      'password_again' => array(
        'required' => true,
        'matches' => 'password'
      ),
      'firstname' => array(
        'required' => true,
        'min' => 2,
        'max' => 50
      ),
      'lastname' => array(
        'required' => true,
        'min' => 2,
        'max' => 50
      )
    ));

        if ($validation->passed()) {
            //register user
            // echo "passed";
            // Session::flash('success', 'You registered successfully!');
            // header('Location: index.php');


            $user = new User();

            echo $salt = Hash::salt(32);
            // die();


            try {

                $user->create(array(
                        'username'  => Input::get('username'),
                        'password'  => Hash::make(Input::get('password'), $salt),
                        'salt'      => $salt,
                        'firstname' => Input::get('firstname'),
                        'lastname'  => Input::get('lastname'),
                        'joined'    => date('Y-m-d H:i:s'),
                        'rights'    => 1
                      ));

                Session::flash('home', 'You have been registered and can now log in!');
                header('Location: index.php');
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {

      //output errors
            // print_r($validation->errors() );
            foreach ($validation->errors() as $error) {
                echo $error, '<br>';
            }
        }
    }
}

 ?>



<form  action="" method="post">
  <div class="field">
    <label for="username">Username</label>
    <input type="text" name="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off" id="username">
  </div>

  <div class="field">
    <label for="password">Choose a password</label>
    <input type="password" name="password" value="" id="password">

  </div>

  <div class="field">
    <label for="password_again">Enter your password again</label>
    <input type="password" name="password_again" value="" id="password_again">

  </div>
  <div class="field">
    <label for="firstname">First name</label>
    <input type="text" name="firstname" value="<?php echo escape(Input::get('firstname')); ?>" id="firstname">

  </div>
  </div>
  <div class="field">
    <label for="lastname">Last name</label>
    <input type="text" name="lastname" value="<?php echo escape(Input::get('lastname')); ?>" id="lastname">

  </div>

  <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
  <input type="submit" value="register">
</form>
