<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
require($INC_DIR. "header.php");
    session_start();
?>
<?php
    if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"]) {
        echo '<h1>Welcome, ' . $_SESSION["displayname"] . '</h1>';
        echo '<a href="logout.php">Not ' . $_SESSION["displayname"] . '? Logout</a>';
    } else {
        Print '<script>window.location.assign("../login/login.php");</script>';
    }
?>
<?php require($INC_DIR. "footer.php"); ?>