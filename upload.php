<?php
// Core Initialization
require_once 'core/init.php';

// Header
include 'includes/header.php';

echo "<div class='maincontainer'>";
$fileUploadMessage = '';

//if (Session::exists('dashboard')) {
//    echo '<p>' . Session::flash('dashboard') .  '</p>';
//}

//print Session::get(Config::get('session/session_name'));

$user = new User();
//echo $user->data()->username;
if ($user->isLoggedIn()) {
    if (isset($_FILES['fileToUpload'])){
        // check if file exists for this user  TO DOOO
        $okExtensions = array('image/jpg', 'image/jpeg', 'image/png','text/plain', 'application/pdf');
        $fileType = $_FILES['fileToUpload']['type'];


        if( in_array( $fileType, $okExtensions) ) {
            // proceed

            $upload = Upload::factory('files', true);
            $upload->file($_FILES['fileToUpload']);


            $results = $upload->upload();
            if ($results) {
                $file = new File();


                $addToDB = $file->addToDb($user->data()->id, $results['full_path'], $results['original_filename']);
                if ($addToDB) {
                    $fileUploadMessage = 'success';
                } else {
                    $fileUploadMessage = 'File already exists';
                }
            }
            var_dump($results['original_filename']);
        }else{

            $fileUploadMessage = 'File type not supported ';



        }
    }
    ?>
    <p>
        Hello <a
                href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->firstname); ?></a>
    </p>





    <div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="text-center">
                        <h3><i class="fa fa-cloud-upload fa-4x"></i></h3>
                        <h2 class="text-center">Upload file here</h2>
                        <div class="panel-body">
                            <form id="resetPasswordform"
                                  role="form" autocomplete="off" class="form" method="post" enctype="multipart/form-data">
                                <!--                                  onsubmit="return (this);">-->
                                <div class="form-group">

                                        <label>Please select or drag your file here</label>
                                        <input id="inputEmail" type="file" name="fileToUpload" class="form-control" value="" aria-describedby="emailHelp">
                                        <small id="emailHelp" class="form-text text-muted"><?php echo $fileUploadMessage;  ?></small>


                                </div>
                                <div class="form-group">
                                    <input id="btn-new-password" name="submit"
                                           class="btn btn-lg btn-primary btn-block" value="Upload file"
                                           type="submit">
                                </div>
                            </form>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>







    <?php

} else {
    Redirect::to('index.php');
}

echo "</div> <!-- //maincontainer -->";

include 'includes/footer.php';