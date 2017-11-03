<?php
session_start();


$GLOBALS['config'] = array(
    'mysql' => array(
        'host'     => '127.0.0.1',
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


// instead of writing 10 lines of coad to require all the files necessary

spl_autoload_register(function($class){
    require_once 'classes/' . $class . '.php';
});

require_once 'functions/sanitize.php';
