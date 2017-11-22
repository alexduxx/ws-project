<?php
require_once 'core/init.php';


$user = new User();

if (!$user->isLoggedIn()) {
  Redirect::to('index.php');
}

if(Input::exists()) {
  if (Token::check(Input::get('token'))) {

      $validate = new Validate();
      $validation = $validate->check($_POST, array(
        'firstname' => array(
                'required' => true,
                'min' => 3,
                'max' => 30
        ),
        'lastname' => array(
                'required' => true,
                'min' => 3,
                'max' => 30
        )
      ));

      if ($validation->passed()) {

        try {
          $user->update(array(
            'firstname' => Input::get('firstname'),
            'lastname'  => Input::get('lastname')
          ));

          Session::flash('home', 'Your details have been updated.');
          Redirect::to('index.php');

        } catch (Exception $e) {
          die($e->getMessage());
        }


      } else {
        foreach ($validation->errorrs() as $error) {
          echo $error, '<br>';
        }
      }
  }
}

 ?>

 <form class="" action="" method="post">
   <div class="fields">
     <label for="firstname">First name</label>
      <input type="text" name="firstname" value="<?php echo escape($user->data()->firstname); ?>">
     <label for="lastname">Last name</label>
      <input type="text" name="lastname" value="<?php echo escape($user->data()->lastname); ?>">

      <input type="submit" name="" value="Update">
      <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
   </div>
 </form>
