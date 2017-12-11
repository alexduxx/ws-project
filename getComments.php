<?php

require_once 'core/init.php';
header('Content-Type: application/json');

if (Session::exists('home')) {
    echo '<p>' . Session::flash('home') . '</p>';
}

//print Session::get(Config::get('session/session_name'));

$user = new User();
//echo $user->data()->username;
if ($user->isLoggedIn()) {


    if (isset($_POST['file'])) {
        $fileId = $_POST['file'];
        $userId = $user->data()->id;
        $file = new File();

        $comments = $file->getFileComments($fileId);
        $allUsers = $user->getAllUsers();

        $arrComments = array();

//        var_dump( $comments );
        foreach ($allUsers as $user) {
//           echo $user->username . '    ';
            foreach ($comments as $comment) {
//               echo $comment->user_id . '    ';
                if ($comment->user_id == $user->id) {
                    $jCommentDetails = json_decode("{}");
                    $jCommentDetails->username = $user->username;
                    $jCommentDetails->commentBody = $comment->body;
                    $jCommentDetails->commentDate = $comment->created_at;

                    array_push($arrComments, $jCommentDetails);

                }

            }
        }

//            return $arrComments;
        echo json_encode($arrComments);

    } else {
        echo 'nu e nimic ';
    }


} else {
    Redirect::to('index.php');
}
