<?php

require_once 'core/init.php';






if (Input::get('code') && Input::get('id')){


    $user = new User();

    $emailActivationCode = Input::get('code');
    $userId = Input::get('id');


    $user->activateAccount($userId,$emailActivationCode);

    if (Input::get('reason') == 'activate'){
        Session::flash('home', 'Your account has been activated and you can now login.');

    }
    if (Input::get('reason') == '3'){
        Session::flash('home', 'Login and then please change your password.');

    }
    if (Input::get('reason') == '5'){
        Session::flash('home', 'Your account has been activated and you can now login, please change your password.');

    }


    Redirect::to('index.php');
}

