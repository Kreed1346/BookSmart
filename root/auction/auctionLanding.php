<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require($INC_DIR . "header.php");
    session_start();
?>
        <nav class="profile-header">
            <a class="return" href="../profile/profile.php">&#10094; Return to Profile Page</a>
        <?php
            if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"]) {
                echo '<h1><a class="profile-name-link" href="../profile/profile.php">' . $_SESSION["displayname"] . '</a></h1>';
                echo '<a class="logout" href="../profile/logout.php">Not ' . $_SESSION["displayname"] . '? Logout.</a>';
            } else {
                header("../login/login.php");
            }
        ?>
        </nav>
        <aside class="resource-sidebar">
            <h1 class="less-bottom-margin">Auctions</h1>
            <?php
                $creation_time = date('Y-m-d H:i:s', strtotime("now"));
                echo '<p>'.$creation_time.'</p>';
//                $creation_date = date_create($creation_time);
//                echo '<p>'.date_format($creation_date, 'Y-m-d H:i:s').'</p>';
            ?>
            <hr/>
            <h2><a href="../auction/createAuction.php">Start an Auction</a></h2>
            <h2><a href="../auction/auctionSearch.php">Search for Auctions</a></h2>
        </aside>
<?php require($INC_DIR . "footer.php"); ?>