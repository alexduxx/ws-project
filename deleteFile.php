<?php

require_once 'core/init.php';

// Header
include 'includes/header.php';

echo "<div class='maincontainer'>";

if (Session::exists('home')) {
    echo '<p>' . Session::flash('home') . '</p>';
}

//print Session::get(Config::get('session/session_name'));

$user = new User();
//echo $user->data()->username;
if ($user->isLoggedIn()) {

    $file = new File();

    if (Input::get('deleteFile')) {
        $pathToFile = Input::get('deleteFile');
        $fileDeleted = $file->deleteFile($pathToFile);

        if ($fileDeleted) {
            Redirect::to('files.php');
        } else {
            die('Something went wrong');
        }
    }


} else {
    Redirect::to('index.php');
}

echo "</div> <!-- //maincontainer -->";

include 'includes/footer.php';
