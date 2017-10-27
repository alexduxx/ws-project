<?php

require_once 'core/init.php';

if (Input::exists()) {
  // echo Input::get('username');

  $validate = new Validate();
  $validation = $validate->check($_POST, array(
    'username' => array(
      'required' => true,
      'min' => 2,
      'max' => 20,
      'unique' => 'users'
    ),
    'password' => array(
      'required' => true,
      'min' => 8
    ),
    'password_again' => array(
      'required' => true,
      'matches' => 'password'
    ),
    'firstname' => array(
      'required' => true,
      'min' => 2,
      'max' => 50
    ),
    'lastname' => array(
      'required' => true,
      'min' => 2,
      'max' => 50
    )
  ));

  if ($validation->passed()) {
    //register user
    echo "passed";
  }else{

    //output errors
    // print_r($validation->errors() );
    foreach ($validation->errors() as $error) {
      echo $error, '<br>';
    }
  }

}

 ?>



<form class="" action="" method="post">
  <div class="field">
    <label for="username">Username</label>
    <input type="text" name="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off" id="username">
  </div>

  <div class="field">
    <label for="password">Choose a password</label>
    <input type="password" name="password" value="" id="password">

  </div>

  <div class="field">
    <label for="password_again">Enter your password again</label>
    <input type="password" name="password_again" value="" id="password_again">

  </div>
  <div class="field">
    <label for="firstname">First name</label>
    <input type="text" name="firstname" value="<?php echo escape(Input::get('firstname')); ?>" id="firstname">

  </div>
  </div>
  <div class="field">
    <label for="lastname">Last name</label>
    <input type="text" name="lastname" value="<?php echo escape(Input::get('lastname')); ?>" id="lastname">

  </div>

  <input type="submit" value="register">
</form>
