<?php
    session_start();
    
    $_SESSION["isLoggedIn"] = false;
    $_SESSION["displayname"] = '';
    $_SESSION['UPDATED'] = false;
    $_SESSION['AUCTION_TEXTBOOK'] = null;
    $_SESSION['AUCTION_INFO'] = null;
    $_SESSION['AUCTION_RESULTS'] = [];
    $_SESSION['AUCTION_POST_FIELDS'] = [];
    $_SESSION['CARD_CREATED'] = false;
    $_SESSION['TEXTBOOKS'] = null;
    $_SESSION['COURSE_INFO'] = null;
    $_SESSION['SEARCH_RESULTS'] = null;

    session_write_close();

    header("Location: ../home/index.php");
?>