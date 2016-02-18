<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require($INC_DIR. "header.php");
    session_start();
    if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"]) {
        header("Location: ../profile/profile.php");
    }
    echo "<section id='registry-success'><p>You are almost fully registered!</p><p>Please check your provided email address to continue the registration process.</p></section>";
    require($INC_DIR. "footer.php");
?>