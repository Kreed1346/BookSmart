<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    session_start();
    require_once($INC_DIR . "header.php");
    require_once($INC_DIR . "top-navbar.php");
    require_once 'activeAuctions.php';
?>
    <section id="auction-landing">
        <aside class="sidebar profile-sidebar float-left">
            <br/>
            <a class="return" href="../profile/profile.php">&lsaquo; Return to Profile Page</a>
            <h1 class="less-bottom-margin">Auctions</h1>
            <hr/>
            <h2><a href="../auction/createAuction.php">Start an Auction</a></h2>
            <h2><a href="../auction/auctionSearch.php">Search for Auctions</a></h2>
        </aside>
        <section class="active-auctions">
            <?php
                if (isset($_SESSION['ACTIVE_AUCTIONS'])) {
                    echo '<h1 class="less-bottom-margin">Active Auctions</h1>';
                    echo '<hr>';
                    foreach ($_SESSION['ACTIVE_AUCTIONS'] as $activeAuction) {
                        echo '<h2><a href="auctionInfo.php?auction_id='.$activeAuction['auction_id'].'">'.$activeAuction['auction_title'].'</a></h2>';
                    }
                }
            ?>
        </section>
    </section>
<?php require($INC_DIR . "footer.php"); ?>