<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    session_start();
    require_once($INC_DIR . "header.php");
    require_once($INC_DIR . "top-navbar.php");
?>
        <aside class="sidebar profile-sidebar">
            <br/>
            <a class="return" href="../profile/profile.php">&#10094; Return to Profile Page</a>
            <h1 class="less-bottom-margin">Auctions</h1>
            <hr/>
            <h2><a href="../auction/createAuction.php">Start an Auction</a></h2>
            <h2><a href="../auction/auctionSearch.php">Search for Auctions</a></h2>
        </aside>
<?php require($INC_DIR . "footer.php"); ?>