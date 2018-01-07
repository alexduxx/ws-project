<?php
// Core Initialization
require_once 'core/init.php';

// Header
include 'includes/header.php';

echo "<div class='maincontainer'>";



if (Input::exists()) {
    // echo Input::get('username');
    if (Token::check(Input::get('token'))) {
        // echo 'Ive been run <br> ';

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
      'username' => array(
        'required' => true,
        'min' => 2,
        'max' => 20,
        'unique' => 'users',
        'lower-case' => true
      ),
      'email' => array(
        'required' => true,
        'unique' => 'users',
        'email-validation' => true
      ),
      'password' => array(
        'required' => true,
        'min' => 8,
        'special-pass-requirements'=> true
      ),
      'password_again' => array(
        'required' => true,
        'matches' => 'password'
      ),
      'firstname' => array(
        'required' => true,
        'min' => 2,
        'max' => 50,
        'upper-lower-case' => true

      ),
      'lastname' => array(
        'required' => true,
        'min' => 2,
        'max' => 50,
        'upper-lower-case' => true
      )
    ));

        if ($validation->passed()) {
            //register user
            // echo "passed";
            // Session::flash('success', 'You registered successfully!');
            // header('Location: index.php');
            $user = new User();

            $user->register();
//            mail('alexduxx@gmail.com','test','test');



        } else {

            //output errors
            // print_r($validation->errors() );
            foreach ($validation->errors() as $error) {


                echo "<span class='reg-err-msg'>";
                echo $error, '<br>';
                echo "</span>";

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
                    <h1>Log in with your email account</h1>
                    <form role="form" action="" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">Email</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="username" value="<?php if(isset($_POST['username'])) { echo escape(Input::get('username')); }?>">
                        </div>
                        <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" value="<?php if(isset($_POST['Account'])) { echo escape(Input::get('Account')); }?>">
                        </div>
                        <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" onkeyup="CheckPasswordStrength(this.value)">
                            <span id="password_strength">Strength...</span>
                        </div>
                        <div class="form-group">
                            <label for="password_again" class="sr-only">Password</label>
                            <input type="password" name="password_again" id="password_again" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="firstname" class="sr-only">Password</label>
                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="firstname" value="<?php if(isset($_POST['firstname'])) { echo escape(Input::get('firstname')); }?>">
                        </div>
                        <div class="form-group">
                            <label for="password_again" class="sr-only">Password</label>
                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="lastname" value="<?php if(isset($_POST['username'])) { echo escape(Input::get('lastname')); }?>">
                        </div>
                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                        <input type="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                    <div class="alert alert-warning show-error" role="alert">



                    </div>

                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

<?php

echo "</div> <!-- //maincontainer -->";

include 'includes/footer.php';