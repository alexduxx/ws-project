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
  <p>Hello  <a href="#"><?php echo escape($user->data()->username); ?> </a></p>

  <ul>
    <li> <a href="logout.php"> Log out </a>  </li>
    <li> <a href="update.php"> Update details </a>  </li>
    <li> <a href="changepassword.php"> Change password </a>  </li>
  </ul>

  <?php
}else {
  echo '<p>You need to <a href="login.php"> log in </a>or<a href="register.php"> register</a>. </p>';
}
