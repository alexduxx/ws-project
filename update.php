<?php
require_once 'core/init.php';


$user = new User();

if (!$user->isLoggedIn()) {
  Redirect::to('index.php');
}

if(Input::exists()) {
  if (Token::check(Input::get('token'))) {

      $validate = new Validate();
      $validation = $validate->check($_POST, array(
        'firstname' => array(
                'required' => true,
                'min' => 3,
                'max' => 30
        ),
        'lastname' => array(
                'required' => true,
                'min' => 3,
                'max' => 30
        )
      ));

      if ($validation->passed()) {

        try {
          $user->update(array(
            'firstname' => Input::get('firstname'),
            'lastname'  => Input::get('lastname')
          ));

          Session::flash('home', '<i>Your details have been updated.</i>');
          Redirect::to('index.php');

        } catch (Exception $e) {
          die($e->getMessage());
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




 <form class="" action="" method="post">
   <div class="fields">
     <label for="firstname">First name</label>
      <input type="text" name="firstname" value="<?php echo escape($user->data()->firstname); ?>">
     <label for="lastname">Last name</label>
      <input type="text" name="lastname" value="<?php echo escape($user->data()->lastname); ?>">

      <input class="button" type="submit" name="" value="Update">
      <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
   </div>
 </form>
