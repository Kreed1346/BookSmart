<?php
    require_once("auction.php");
    session_start();
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }

        $new_bid = mysqli_real_escape_string($link, $_POST['new_bid']); //sanitize new_bid input
        
        $bid_query = mysqli_query($link, "SELECT * FROM bids WHERE auction_id={$_SESSION['AUCTION_INFO']->getAuctionId()}");
        
        $bidIsHigher = false;
        $bidEntryExists = (mysqli_num_rows($bid_query) > 0) ? true : false;
        $bidderNotAuctioneer = ($_SESSION['username'] !== $_SESSION['AUCTION_INFO']->getSellerUserName()) ? true : false;
        if ($bid_query !== null && $bidEntryExists) {
            while($row = mysqli_fetch_array($bid_query)) {
                if ($new_bid > $row['bid_amount']) {
                    $bidIsHigher = true;
                }
            }
        }
        $user_query = mysqli_query($link, "SELECT * FROM users WHERE username='{$_SESSION['username']}'");
        $user_id = mysqli_fetch_array($user_query)['id'];
        if ($bidderNotAuctioneer) {
            if ($bidEntryExists) {
                if ($bidIsHigher) {
                    mysqli_query($link, "UPDATE bids SET user_id='$user_id', bid_amount='$new_bid' WHERE auction_id='{$_SESSION['AUCTION_INFO']->getAuctionId()}'");
                } else {
                    Print '<script>window.alert("Attempted bid is lower than the current highest bid."</script>';
                }
            } else {
                echo "Hey it went here";
                mysqli_query($link, "INSERT INTO bids (user_id, auction_id, bid_amount) VALUES ($user_id,{$_SESSION['AUCTION_INFO']->getAuctionId()}, $new_bid)");

            }
        } else {
            Print '<script>window.alert("Attempted bid was made by the auctioneer."</script>';
        }
        
        
        mysqli_close($link);
        header("Location: auctionInfo.php?auction_id=".$_SESSION['AUCTION_INFO']->getAuctionId());
    }
?>