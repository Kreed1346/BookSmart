<?php
    session_start();
    $_SESSION = array();
    session_write_close();
    session_destroy();
    header("Location: ../home/index.php");
?>