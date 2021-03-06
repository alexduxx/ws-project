<?php
session_start();



$GLOBALS['config'] = array(
    'mysql' => array(
        'host'     => 'localhost',
        'username' => 'root',
        'password' => '',
        'db'       => 'ws-project'
    ),
    'remember'=> array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 800000
    ),
    'session'=> array(
        'session_name' => 'user',
        'token_name' => 'token'
    )
);


// instead of writing 10 lines of code to require all the files necessary

spl_autoload_register(function($class){
    require_once 'classes/' . $class . '.php';
});

require_once 'functions/sanitize.php';

if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {

  $hash = Cookie::get(Config::get('remember/cookie_name'));
  $hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));

  if ($hashCheck->count()) {
    $user = new User($hashCheck->first()->user_id); // get the users id
    $user->login();
  }

}
