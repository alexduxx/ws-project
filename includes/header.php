<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ws-Exam-project</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/style.css">


    <style media="screen">
        .maincontainer {
            margin-top: 70px;
        }
    </style>


</head>
<body>

<div class="container ">
    <div class="row">


        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                            aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">B-storage</a>
                </div>


 <?php
                    $user = new User();
                    if ($user->isLoggedIn()) {


 ?>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li><a href="files.php">Files</a></li>
                        <li><a href="upload.php">Upload</a></li>

                    </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                                    role="button" aria-haspopup="true" aria-expanded="false">Account
                                    <span class="caret"></span></a>

                                <ul class="dropdown-menu">
                                    <li><a href="profile.php?user=<?php echo escape($user->data()->username); ?>">Profile <?php echo escape($user->data()->firstname); ?></a>
                                    </li>
                                    <li><a href="update.php">Update</a></li>
                                    <li><a href="changepassword.php">Change Password</a></li>
                                    <li><a href="logout.php">Logout</a></li>

                                </ul>

                            </li>
                        </ul>
                    <?php } // end isLoggedIn
                    else { ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="login.php">Login</a></li>
                            <li><a href="register.php">Register</a></li>
                        </ul>
                    <?php } // end else  ?>

                </div><!--/.nav-collapse -->

            </div>
        </nav>
