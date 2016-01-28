<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require($INC_DIR . "header.php");
    session_start();
?>
        <nav class="profile-header">
            <a class="return" href="../auction/auctionLanding.php">&#10094; Return to Auction Landing Page</a>
        <?php
            if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"]) {
                echo '<h1><a class="profile-name-link" href="../profile/profile.php">' . $_SESSION["displayname"] . '</a></h1>';
                echo '<a class="logout" href="logout.php">Not ' . $_SESSION["displayname"] . '? Logout.</a>';
            } else {
                header("../login/login.php");
            }
        ?>
        </nav>
        <section>
            
        </section>
<?php require($INC_DIR . "footer.php"); ?>