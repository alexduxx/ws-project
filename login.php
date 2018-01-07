<?php
// Core Initialization
require_once 'core/init.php';

// Header
include 'includes/header.php';

echo "<div class='maincontainer'>";


if (Input::exists()) {
      if (Token::check(Input::get('token'))) {
          $validate = new Validate();
          $validation =$validate->check($_POST, array(
        'username' => array('required' => true),
        'password' => array('required' => true)
      ));

          if ($validation->passed()) {
              // log user in
              $user = new User();

              if (!isset($_POST['remember'])) {
                  $remember= false;
              } else {
                  $remember = (Input::get('remember') === 'on') ? true : false;
              }


              $login = $user->login(Input::get('username'), Input::get('password'), $remember);

              if ($login) {
                  Redirect::to('dashboard.php');
              } else {
                  echo '<p>Username or password incorect. </p>';

              }
          } else {
              foreach ($validation->errors() as $error) {
                  echo $error, '<br>';
              }
          }
      }
  }

 ?>




    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-wrap">
                        <h1>Log in to B-storage</h1>
                        <form role="form" action="" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="username" class="sr-only">Email</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="somebody">
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="form-group">

                                <label for="remember" >Remember me</label>
                                <input type="checkbox" name="remember" id="remember" >
                            </div>
                            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                            <input type="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Log in">
                        </form>

                        <hr>
                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>




<?php

echo "</div> <!-- //maincontainer -->";

include 'includes/footer.php';