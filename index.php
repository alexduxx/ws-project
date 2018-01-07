<?php
// Core Initialization
require_once 'core/init.php';

// Header
include 'includes/header.php';

echo "<div class='maincontainer'>";

if (Session::exists('home')) {
    echo '<p>' . Session::flash('home') .  '</p>';
}
echo '<p>' . Session::flash('home') .  'fdsgsdfgsdfgfdsgdfsgsfd</p>';
//print Session::get(Config::get('session/session_name'));

$user = new User();
//echo $user->data()->username;
if ($user->isLoggedIn()) {


    Redirect::to('dashboard.php');


//    echo "<p class='label label-success'>Success! You are logged in!</p><br><br>";
//    ?>
<!--    <p>-->
<!--        Hello <a href="profile.php?user=--><?php //echo escape($user->data()->username); ?><!--">--><?php //echo escape($user->data()->name); ?><!--</a>-->
<!--    </p>-->
<!---->
<!--    <ul>-->
<!--        <li><a href="update.php">Update</a></li>-->
<!--        <li><a href="changepassword.php">Change Password</a></li>-->
<!--        <li><a href="logout.php">Logout</a></li>-->
<!---->
<!--    </ul>-->
    <?php
    // User Permission
//            if ($user->hasPermission('admin')) {
//                echo "<p>You are an Administrator!</p>";
//            }

} else {

    ?>


    <header id="page-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <img class="img-responsive" src="img/B-StorageLogo.png" width="100px" alt="">
                    <div class="intro-text">
                        <span class="name">Welcome to Banana Storage</span>
                        <hr class="star-light">
                        <p class="skills">B-storage</p>
                        <a class="btn btn-danger btn-lg wow fadeInDown waves-effect waves-light" href="login.php"><i class="fa fa-diamond"></i> Log in</a>
                        <a class="btn btn-primary btn-lg wow fadeInDown waves-effect waves-light" href="register.php"><i class="fa fa-shield"></i> Register</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="content-wrapper">
        <section class="primary" id="portfolio">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2>PORTAFOLIO</h2>
                        <hr class="star-primary">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <img src="http://lorempixel.com/360/260/nature/">
                    </div>
                    <div class="col-sm-4">
                        <img src="http://lorempixel.com/360/260/animals/">
                    </div>
                    <div class="col-sm-4">
                        <img src="http://lorempixel.com/360/260/abstract/">
                    </div>
                </div>
            </div>
        </section>
        <section class="success" id="about">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2>About</h2>
                        <hr class="star-light">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-lg-offset-2">
                        <p>Freelancer is a free bootstrap theme created by Start Bootstrap. The download includes the complete source files including HTML, CSS, and JavaScript as well as optional LESS stylesheets for easy customization.</p>
                    </div>
                    <div class="col-lg-4">
                        <p>Whether you're a student looking to showcase your work, a professional looking to attract clients, or a graphic artist looking to share your projects, this template is the perfect starting point!</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="primary" id="contact">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2>Contact</h2>
                        <hr class="star-primary">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <!-- To configure the contact form email address, go to mail/contact_me.php and update the email address in the PHP file on line 19. -->
                        <!-- The form should work on most web servers, but if the form is not working you may need to configure your web server differently. -->
                        <form name="sentMessage" id="contactForm" novalidate="">
                            <div class="row control-group">
                                <div class="form-group col-xs-12 floating-label-form-group controls">
                                    <label>Name</label>
                                    <input type="text" class="form-control" placeholder="Name" id="name" required="" data-validation-required-message="Please enter your name.">
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="row control-group">
                                <div class="form-group col-xs-12 floating-label-form-group controls">
                                    <label>Email Address</label>
                                    <input type="email" class="form-control" placeholder="Email Address" id="email" required="" data-validation-required-message="Please enter your email address.">
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="row control-group">
                                <div class="form-group col-xs-12 floating-label-form-group controls">
                                    <label>Phone Number</label>
                                    <input type="tel" class="form-control" placeholder="Phone Number" id="phone" required="" data-validation-required-message="Please enter your phone number.">
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="row control-group">
                                <div class="form-group col-xs-12 floating-label-form-group controls">
                                    <label>Message</label>
                                    <textarea rows="5" class="form-control" placeholder="Message" id="message" required="" data-validation-required-message="Please enter a message."></textarea>
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <br>
                            <div id="success"></div>
                            <div class="row">
                                <div class="form-group col-xs-12">
                                    <button type="submit" class="btn btn-success btn-lg">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>










    <?php
}

echo "</div> <!-- //maincontainer -->";

include 'includes/footer.php';
