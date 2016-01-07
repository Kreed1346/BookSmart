<?php
    session_start();
    
    $_SESSION["isLoggedIn"] = false;
    $_SESSION["displayname"] = '';

    session_write_close();

    Print '<script>window.location.assign("../home/index.php");</script>';
?>