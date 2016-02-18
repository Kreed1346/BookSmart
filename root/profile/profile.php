<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    session_start();
    require($INC_DIR . "header.php");
    require($INC_DIR . "top-navbar.php");
?>
    <section>
        <aside class="sidebar resource-sidebar">
            <h1 class="less-bottom-margin">Resources</h1>
            <hr/>
            <a class="resource-link" href="../courses/search.php"><aside id="profile-courses" class="more-bottom-margin custom-box-shadow"><p>Course Search</p></aside></a>
            <a class="resource-link" href="../auction/auctionLanding.php"><aside id="profile-auctions" class="more-bottom-margin custom-box-shadow"><p>Auction Search</p></aside></a>
        </aside>
        <aside class="sidebar profile-sidebar">
            <h1 class="less-bottom-margin">Profile</h1>
            <hr/>
            <h2><a href="profileSettings.php">Change Profile Settings</a></h2>
<!--            <h2><a href="../billing/billingInformation.php">Billing Information</a></h2>-->
        </aside>
    </section>
<?php require($INC_DIR . "footer.php"); ?>