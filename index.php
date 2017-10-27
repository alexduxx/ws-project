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

$user = DB::getInstance()->update('users', 3, array(

  'password' => 'NewtestPass',
  'firstname' => 'tralalala'


));
