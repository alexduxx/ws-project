<?php

require_once 'core/init.php';


// $user = DB::getInstance()->get('users', array('username','=','robertox'));
//
// if (!$user->count()) {
//   echo 'No User';
//
// }else{
//
//     echo $user->first()->firstname, '</br>';
//
// }

// $user = DB::getInstance()->update('users', 3, array(
//
//   'password' => 'NewtestPass',
//   'firstname' => 'tralalala'
//
//
// ));

// if (Session::exists('home')) {
//     echo '<p>' . Session::flash('success'); '</p>';
// };
if (Session::exists('home')) {
    echo '<p>' . Session::flash('home'); '</p>';
};

# check the session name
// echo Session::get(Config::get('session/session_name'));


$user = new User(); // current
if ($user->isLoggedIn()) {

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

    .options{
      display: flex;
      flex-direction: column;
      width: 700px;
      padding: 50px;
      border: 1px solid #999999;
      background-color: white;
    }

    #options{
      width: 100%;
      height: 50px;
      padding: 10px;
      margin-top: 10px;
      margin-bottom: 10px;
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
      margin-top: 5%;
      margin-left: 5%;
    }

    a{
      text-decoration: none;
    }

    li{
      list-style: none;
    }

    .list{
      color: #FFB74D;
    }


  </style>


  
  <div class="options">
    <div class="field-img">
      <img class="banana" src="B-StorageLogo.png">
      <h1>Hello<a> <?php echo escape($user->data()->username); ?> </a>, you are now loggedin to your account.</h1>
    </div>

    <ul id="options">
      <li> 
        <a class="list" href="logout.php"> Log out </a>  
      </li>

      <li> 
        <a class="list" href="update.php"> Update details </a>  
      </li>

      <li> 
        <a class="list" href="changepassword.php"> Change password
      </li>
    </ul>
  </div>

  <?php

    }else {
      echo '<div class="options">
            <img class="banana" src="B-StorageLogo.png">
            <p>You need to <a href="login.php"> log in </a>or<a href="register.php"> register</a>.</p> 
            </div>
      
      <style>
        html, body{
          height: 100%;
          background-color: #FFF3E0;
          color: #222;    
          font-family: "Roboto", sans-serif;
        }
        body{
          display: flex;
          justify-content: center;
          align-items: center;
        }
        .options{
          display: flex;
          width: 350px;
          padding: 50px;
          border: 1px solid #999999;
          background-color: white;
        }
        a{
          text-decoration: none;
          color: #FFB74D;
        }
        p{
          padding-top: 10%;
          padding-left: 5%;
        }
        .banana{
          width: 50px;
          height: 100px;
          padding-bottom: 2%;
        }
      </style>';
    }

  ?>