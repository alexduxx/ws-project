<?php

require_once 'core/init.php';

// var_dump(Token::check(Input::get('token')));

if (Input::exists()) {
    // echo Input::get('username');
    if (Token::check(Input::get('token'))) {
        // echo 'Ive been run <br> ';

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

            // $salt = Hash::salt(32);
            // die();


            try {
                $user->create(array(
                        'username'  => Input::get('username'),
                        'password'  => Hash::make(Input::get('password')),
                        'firstname' => Input::get('firstname'),
                        'lastname'  => Input::get('lastname'),
                        'joined'    => date('Y-m-d H:i:s'),
                        'rights'    => 1
                      ));

                Session::flash('home', 'You have been registered and can now log in!');
                // Redirect::to(404);
                Redirect::to('index.php');
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



 <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">

  <style type="text/css">
    
    html, body{
      height: 100%;
      background-color: #FFF3E0;
      color: #222;    
      font-family: 'Roboto', sans-serif;
    }

    *{
      margin: 0px;
      padding: 0px;
      font-size: 16px;
      box-sizing: border-box;
    }

    body{
      display: flex;
      justify-content: center;
      align-items: center;
    }

    form{
      display: flex;
      flex-direction: column;
      width: 600px;
      padding: 20px 30px 20px 30px;
      border: 1px solid #999999;
      background-color: white;

    }

    input{
      width: 100%;
      height: 50px;
      padding: 10px;
      margin-top: 10px;
      margin-bottom: 10px;
    }

    .button{
      width: 100%;
      height: 50px;
      color: white;
      border: none;
      background-color: #FFB74D;
      cursor: pointer;
    }

    .field-img{
      display: flex;
      flex-wrap: wrap;
    }

    .banana{
      width: 50px;
      height: 100px;
      padding-bottom: 2%;
    }

    .welcome{
      margin-top: 5%;
      margin-left: 5%;
    }

    h1{
      font-weight: 700;
    }

    a{
      text-decoration: none;
      color: #FFB74D;
    }



  </style>



<form  action="" method="post">
  <div class="field-img">
      <img class="banana" src="B-StorageLogo.png">
        <div class="welcome">
          <h1>WELCOME TO B-STORAGE!</h1><br>
          <p> Please register or login <a href="login.php">here</a>.</p>
        </div>  
  </div>

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
  <input class="button" type="submit" value="register">
</form>
