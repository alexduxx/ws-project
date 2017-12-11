<?php

require_once 'core/init.php';






if (Input::get('code') && Input::get('id')){


    $user = new User();

    $emailActivationCode = Input::get('code');
    $userId = Input::get('id');


    $user->activateAccount($userId,$emailActivationCode);

    Session::flash('home', 'Your account has been activated and you can now login.');
    Redirect::to('index.php');
}