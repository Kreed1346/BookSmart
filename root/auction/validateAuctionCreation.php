<?php
    session_start();
    $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    $auctionTitle = mysqli_real_escape_string($link, $_POST['auctionTitle']);
    $auctionDesc = mysqli_real_escape_string($link, $_POST['auctionDesc']);
    $book = mysqli_real_escape_string($link, $_POST['book']);
    $bin_price = $_POST['bin_price'];
    $start_bid_price = $_POST['start_bid_price'];
    $creation_time = date('Y-m-d H:i:s', strtotime("now"));
    $end_time = date('Y-m-d H:i:s', strtotime("+1 week"));

    $user_query = mysqli_query($link, "SELECT * FROM users WHERE username='".$_SESSION["username"]."'");
    $user_id = mysqli_fetch_array($user_query)['id'];

    mysqli_query($link, "INSERT INTO auctions (auction_title, auction_desc, isbn, user_id, bin_price, start_bid_price, auction_creation_time, auction_end_time) VALUES ('$auctionTitle','$auctionDesc','$book',$user_id,'$bin_price','$start_bid_price','$creation_time','$end_time')");

    $auction_id = mysqli_insert_id($link);

    mysqli_close($link);
    session_write_close();
    header("Location: auctionInfo.php?auction_id=".$auction_id);
?>