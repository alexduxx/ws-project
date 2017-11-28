<?php

require_once 'core/init.php';



?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link href="style/style.css" rel="stylesheet">

  </head>


  <body>


<?php

          if (Session::exists('home')) {
              echo '<p>' . Session::flash('home');
              '</p>';
          };



          $user = new User(); // current
          if ($user->isLoggedIn()) {
?>







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






</body>
</html>

  <?php

} else {
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
