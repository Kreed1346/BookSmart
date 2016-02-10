<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    session_start();
    require($INC_DIR . "header.php");
    require($INC_DIR . "top-navbar.php");
?>
        
        <section id="auction">
            <br/>
            <a class="return" href="../auction/auctionLanding.php">&#10094; Return to Auction Landing Page</a>
            <h1>Create an Auction Listing</h1>
            <form action="createAuction.php" method="POST">
                <label for="auctionTitle">Auction Title</label><br/>
                <input type="text" name="auctionTitle" placeholder="Enter auction title here." required/><br/>
                <label for="auctionDesc">Auction Description</label><br/>
                <textarea name="auctionDesc" rows="4" cols="50" placeholder="Enter auction description here." required></textarea><br/>
                <label for="isbn">ISBN of Book for Sale</label><br/>
                <input type="text" name="isbn" pattern="[0-9]{10,13}" required><br/>
                <label for="bin_price">Buy-It-Now Price</label><br/>
                <input type="number" min="0.01" step="0.01" max="500" value="0.01" name="bin_price"/><br/>
                <label for="start_bid_price">Starting Bid Price</label><br/>
                <input type="number" min="0.01" step="0.01" max="500" value="0.01" name="start_bid_price"/><br/>
                <input class="submit-btn" type="submit" name="submit" value="Submit">
            </form>
        </section>
<?php require($INC_DIR . "footer.php"); ?>

<?php
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }
            
            $auctionTitle = mysqli_real_escape_string($link, $_POST['auctionTitle']);
            $auctionDesc = mysqli_real_escape_string($link, $_POST['auctionDesc']);
            $isbn = mysqli_real_escape_string($link, $_POST['isbn']);
            $bin_price = $_POST['bin_price'];
            $start_bid_price = $_POST['start_bid_price'];
            $creation_time = date('Y-m-d H:i:s', strtotime("now"));
            $end_time = date('Y-m-d H:i:s', strtotime("+1 week"));
//            echo $creation_time;
//            $creation_date = date_create($creation_time);
//            echo date_format($creation_date, 'Y-m-d H:i:s');
//            //'Y-m-d H:i:s'
//            $end_time = strtotime("+1 week");
            
            $user_query = mysqli_query($link, "SELECT * FROM users WHERE username='".$_SESSION["username"]."'");
            $user_id = mysqli_fetch_array($user_query)['id'];
            
            mysqli_query($link, "INSERT INTO auctions (auction_title, auction_desc, isbn, user_id, bin_price, start_bid_price, auction_creation_time, auction_end_time) VALUES ('$auctionTitle','$auctionDesc','$isbn',$user_id,'$bin_price','$start_bid_price','$creation_time','$end_time')");
            
            $auction_id = mysqli_insert_id($link);

            mysqli_close($link);
            session_write_close();
            header("Location: auctionInfo.php?auction_id=".$auction_id);
        }
?>