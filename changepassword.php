<?php

require_once 'core/init.php';

$user = new User();

if (!$user->isLoggedIn()) {
  Redirect::to('index.php');

}

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {

      $validate = new Validate();
      $validation = $validate->check($_POST, array(
        'password_current' => array(
          'required' => true,
          'min'=> 8
        ),
        'password_new' => array(
          'required' => true,
          'min' => 8,
          'special-pass-requirements' => true
        ),
        'password_new_again' => array(
          'required' => true,
          'min' => 8,
          'matches' => 'password_new'
        )

      ));

      if ($validation->passed()) {
        # change of password

        if (!password_verify(Input::get('password_current'), $user->data()->password))  {
          echo 'Your current password is wrong';
        }else{

          $user->update(array(
            'password' => Hash::make(Input::get('password_new'))
          ));

          Session::flash('home', 'Your password has been changed');
          Redirect::to('dashboard.php');
        }

      }else{
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




 <form class="" action="" method="post">
   <div class="field">
     <label for="password_current">Current password</label>
     <input type="password" name="password_current" id="password_current" value="">
   </div>
   <div class="field">
     <label for="password_new">New password</label>
     <input type="password" name="password_new" id="password_new" value="">
   </div>
   <div class="field">
     <label for="password_new_again">New password again</label>
     <input type="password" name="password_new_again" id="password_new_again" value="">
   </div>

   <input class="button" type="submit" name="" value="Change">
   <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

 </form>
