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

    if (isset($_POST['comment-submit'])){
        if (isset($_GET['file_id']) && isset($_POST['comment']) ){

            $fileId = escape($_GET['file_id']);
            $fileComment = escape($_POST['comment']);
            $userId = $user->data()->id;

//            echo $fileId . '  ' . $fileComment;
            $file = new File();
            if ($file->addComment($fileId, $fileComment, $userId)){
//                echo 'BRAVO';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }else{
                echo 'Something went wrong with adding the comment.';
            }


        }
    }


} else {
    Redirect::to('index.php');
}

echo "</div> <!-- //maincontainer -->";

include 'includes/footer.php';
