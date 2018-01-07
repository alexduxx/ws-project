<?php
// Core Initialization
require_once 'core/init.php';

// Header
include 'includes/header.php';

echo "<div class='maincontainer'>";

$user = new User();

if ($user->isLoggedIn()) {
$files = new File();
?>
<p>
    Hello <a
            href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->firstname); ?></a>
</p>


<!-- delete file confirm modal -->

<div aria-hidden="true" aria-labelledby="confirmFileDelete" class="modal fade" id="confirmFileDeleteModal" role="dialog"
     tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title">Delete file </h2>
            </div>

            <div class="modal-body">
                <p>Are you sure you want to delete the file?</p>
            </div>


            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button"
                        onclick="window.location='deleteFile.php?deleteFile=<?php echo $_GET['deleteFile']; ?>'">
                    Yes
                </button>
                <button class="btn btn-success" data-dismiss="modal" type="button"
                        onclick="window.location='files.php';">No
                </button>
            </div>
        </div>
    </div>
</div>
    <!--comment modal-->

<div aria-hidden="true" aria-labelledby="CommentModalLabel" class="modal fade" id="CommentModal" role="dialog"
     tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">Comments</h5>
            </div>
            <div class="modal-body">
                <div class="container comments-container">
                </div>
                <form class="form-horizontal" id="comment-form" method="post" name="comment-form" role="form">
                    <div class="form-group">
                        <label class="col-sm-12 control-label" for="comment_textbox">Comment*</label>

                        <div class="col-sm-12">
                            <input class="form-control" id="comment_textbox" maxlength="255" name="comment" placeholder="Comment" required tabindex="1" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3">
                                <input class="form-control btn btn-login btn-success" id="comment-submit"
                                       name="comment-submit" tabindex="4" type="submit" value="Add">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>



<div id="main-content" class="container-fluid" style="margin-top: 50px;">
    <div class="container">
        <h2>Your files</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>file name</th>
                    <th>uploaded at</th>
                    <th>options</th>
                </tr>
                </thead>
                <tbody>
                <?php

                $files->getUserFiles($user->data()->id);

                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php




} else {
Redirect::to('index.php');
}

echo "</div> <!-- //maincontainer -->";


include 'includes/footer.php';
?>
