<?php

// Core Initialization
require_once 'core/init.php';



// Header
include 'includes/header.php';


echo "<div class='maincontainer'>";

$user = new User();

if ($user->isLoggedIn() && $user->data()->username === Input::get('user')) {


    if (!$username = Input::get('user')) {
        Redirect::to('index.php');
    } else {
        $user = new User($username);
        if (!$user->exists()) {
            Redirect::to(404);
        } else {
            //echo "User exists!";
            $data = $user->data();
        }
        ?>

        <h3><?php echo escape($data->firstname); ?></h3>
        <p>Username: <?php echo escape($data->username); ?></p>


        <?php
    }
}  else {
    Session::flash('home', "You dont have permission to view this.");
    Redirect::to('index.php');
}


echo "</div> <!-- //maincontainer -->";
include 'includes/footer.php';
