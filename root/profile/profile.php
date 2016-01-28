<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require($INC_DIR . "header.php");
    session_start();
?>
        <nav class="profile-header">
        <?php
            if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"]) {
                echo '<h1><a class="profile-name-link" href="profile.php">Welcome, ' . $_SESSION["displayname"] . '</a></h1>';
                echo '<a class="logout" href="logout.php">Not ' . $_SESSION["displayname"] . '? Logout.</a>';
            } else {
                Print '<script>window.location.assign("../login/login.php");</script>';
            }
        ?>
        </nav>
        <aside class="resource-sidebar">
            <h1 class="less-bottom-margin">Resources</h1>
            <hr/>
            <h2><a href="../courses/search.php">Search for Courses</a></h2>
            <h2><a href="../auction/auctionLanding.php">Search for Book Auctions</a></h2>
            <h1 class="top-margin less-bottom-margin">Profile</h1>
            <hr/>
            <h2><a href="profileSettings.php">Change Profile Settings</a></h2>
            <h2><a href="../billing/billingInformation.php">Billing Information</a></h2>
        </aside>
<?php require($INC_DIR . "footer.php"); ?>