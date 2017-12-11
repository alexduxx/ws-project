<?php
// Core Initialization
require_once 'core/init.php';

// Header
include 'includes/header.php';

echo "<div class='maincontainer'>";



$user = new User();
//echo $user->data()->username;
if ($user->isLoggedIn()) {


    ?>
    <p>
        Hello <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->firstname);   ?></a>
    </p>


    <?php










} else {
    Redirect::to('index.php');
}

echo "</div> <!-- //maincontainer -->";

include 'includes/footer.php';