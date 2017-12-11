<?php
// Core Initialization
require_once 'core/init.php';

// Header
include 'includes/header.php';

echo "<div class='maincontainer'>";

if (Session::exists('home')) {
    echo '<p>' . Session::flash('home') .  '</p>';
}

//print Session::get(Config::get('session/session_name'));

$user = new User();
//echo $user->data()->username;
if ($user->isLoggedIn()) {


    Redirect::to('dashboard.php');


//    echo "<p class='label label-success'>Success! You are logged in!</p><br><br>";
//    ?>
<!--    <p>-->
<!--        Hello <a href="profile.php?user=--><?php //echo escape($user->data()->username); ?><!--">--><?php //echo escape($user->data()->name); ?><!--</a>-->
<!--    </p>-->
<!---->
<!--    <ul>-->
<!--        <li><a href="update.php">Update</a></li>-->
<!--        <li><a href="changepassword.php">Change Password</a></li>-->
<!--        <li><a href="logout.php">Logout</a></li>-->
<!---->
<!--    </ul>-->
    <?php
    // User Permission
//            if ($user->hasPermission('admin')) {
//                echo "<p>You are an Administrator!</p>";
//            }

} else {
    echo "<p>You need to <a href='login.php'>log in</a> or <a href='register.php'>register</a></p>";
}

echo "</div> <!-- //maincontainer -->";

include 'includes/footer.php';
