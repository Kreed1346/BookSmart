<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    session_start();
    require($INC_DIR . "header.php");
    require($INC_DIR . "top-navbar.php");
?>
        <aside class="resource-sidebar">
            <h1 class="less-bottom-margin">Resources</h1>
            <hr/>
            <h2><a href="../courses/search.php">Search for Courses</a></h2>
            <h2><a href="../auction/auctionLanding.php">Book Auctions</a></h2>
            <h1 class="top-margin less-bottom-margin">Profile</h1>
            <hr/>
            <h2><a href="profileSettings.php">Change Profile Settings</a></h2>
            <h2><a href="../billing/billingInformation.php">Billing Information</a></h2>
        </aside>
<?php require($INC_DIR . "footer.php"); ?>