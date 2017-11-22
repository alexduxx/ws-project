<?php

require_once 'core/init.php';

$user = new User();

if (!$user->isLoggedIn()) {
  Redirect::to('index.php');

}

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {

      $validate = new Validate();
      $validation = $validate->check($_POST, array(
        'password_current' => array(
          'required' => true,
          'min'=> 8
        ),
        'password_new' => array(
          'required' => true,
          '8' => 8
        ),
        'password_new_again' => array(
          'required' => true,
          '8' => 8,
          'matches' => 'password_new'
        )

      ));

      if ($validation->passed()) {
        # change of password

        if (!password_verify(Input::get('password_current'), $user->data()->password))  {
          echo 'Your current password is wrong';
        }else{
          
          $user->update(array(
            'password' => Hash::make(Input::get('password_new'))
          ));

          Session::flash('home', 'Your password has been changed');
          Redirect::to('index.php');
        }

      }else{
        foreach ($validation->errors() as $error) {
          echo $error, '<br>';
        }
      }
    }
}

 ?>


 <form class="" action="" method="post">
   <div class="field">
     <label for="password_current">Current password</label>
     <input type="password" name="password_current" id="password_current" value="">
   </div>
   <div class="field">
     <label for="password_new">New password</label>
     <input type="password" name="password_new" id="password_new" value="">
   </div>
   <div class="field">
     <label for="password_new_again">New password again</label>
     <input type="password" name="password_new_again" id="password_new_again" value="">
   </div>

   <input type="submit" name="" value="Change">
   <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

 </form>
