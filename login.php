<?php
require_once 'core/init.php';

  if (Input::exists()) {
      if (Token::check(Input::get('token'))) {
          $validate = new Validate();
          $validation =$validate->check($_POST,array(
        'username' => array('required' => true),
        'password' => array('required' => true)
      ));

          if ($validation->passed()) {
              // log user in
              $user = new User();

              $remember = (Input::get('remember') === 'on') ? true : false;

              $login = $user->login(Input::get('username'), Input::get('password'), $remember);

              if ($login) {
                  Redirect::to('index.php');
              } else {
                  echo '<p>Sorry, logging in failed. </p>';
              }
          } else {
              foreach ($validation->errorrs() as $error) {
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
      width: 700px;
      padding: 50px;
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


<form action="" method="post">
  <div class="field-img">
    <img class="banana" src="B-StorageLogo.png">
    <div class="welcome">
      <h1>WELCOME TO B-STORAGE!</h1>
      <p> Please login to your account or register <a href="register.php">here</a>.</p>
    </div>
  </div>
  <div class="field">
    <label for="username">Username</label>
    <input type="text" name="username" id="username" autocomplete="off">
  </div>
  <div class="field">
    <label for="password">Password</label>
    <input type="password" name="password" id="password" autocomplete="off">
  </div>
  <div class="field">
    <label for="remember">Remember me</label>
      <input type="checkbox" name="remember" id="remember">
  </div>

  <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
  <input class="button" type="submit" value="Log in">
</form>
