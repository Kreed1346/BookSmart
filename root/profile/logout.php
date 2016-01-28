<?php
    session_start();
    
    $_SESSION["isLoggedIn"] = false;
    $_SESSION["displayname"] = '';

    session_write_close();

    header("Location: ../home/index.php");
?>