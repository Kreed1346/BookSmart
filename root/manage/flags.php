<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require '../profile/user.php';
    session_start();
    require($INC_DIR . "header.php");
    require($INC_DIR . "top-navbar.php");
    if (!$_SESSION['USER_INFO']->getAdminStatus()) {
        if (!$_SESSION['USER_INFO']->getModStatus()) {
            header("Location: ../profile/profile.php");
        }
    }
?>

<?php require($INC_DIR . "footer.php"); ?>