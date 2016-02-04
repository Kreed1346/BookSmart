<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require_once($INC_DIR . "header.php");
    require_once("auction.php");
    require_once("../books/bookLookup.php");
    session_start();
?>
<script src="https://checkout.stripe.com/checkout.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<?php
    if($_SERVER["REQUEST_METHOD"] == "GET") {
        $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        if (isset($_GET['auction_id'])) {
            $auction_id = mysqli_real_escape_string($link, $_GET['auction_id']); //sanitize auction_id input
        } else {
            $auction_id = $_SESSION['AUCTION_INFO']->getAuctionId();
        }
        $auction_query = mysqli_query($link, "SELECT * FROM auctions WHERE auction_id='$auction_id'");
        
        $auction = new Auction;
        
        if ($auction_query !== null) {
            while($row = mysqli_fetch_array($auction_query)) {
                $auction->setAuctionId($row['auction_id']);
                $auction->setAuctionTitle($row['auction_title']);
                $auction->setAuctionDesc($row['auction_desc']);
                $auction->setISBN($row['isbn']);
                $auction->setBINPrice($row['bin_price']);
                $auction->setStartBidPrice($row['start_bid_price']);
                $auction->setUserId($row['user_id']);
                $auction->setCreationTime($row['auction_creation_time']);
                $auction->setEndTime($row['auction_end_time']);
                $auction->setAuctionEnded($row['auction_ended']);
                $auction->setWinnerUserName($row['winner_username']);
            }
        }
        $user_id = $auction->getUserId();
        $user_query = mysqli_query($link, "SELECT * FROM users WHERE id=$user_id");
        if ($user_query !== null) {
            while($row = mysqli_fetch_array($user_query)) {
                $auction->setSellerUserName($row['username']);
                $auction->setSellerDisplayName($row['displayname']);
            }
        }
        
        $bid_query = mysqli_query($link, "SELECT * FROM bids WHERE auction_id={$auction->getAuctionId()}");
        $highest_bid = 0.00;
        if ($bid_query !== null) {
            while($row = mysqli_fetch_array($bid_query)) {
                if ($highest_bid < $row['bid_amount']) {
                    $highest_bid = $row['bid_amount'];
                }
            }
        }
        
        $textbook = null;
        
        //Check to see if ISBN 10/13 is set for the textbook being offered for sale (Should either always return a result or have no result)
        if (!empty($auction->getISBN()) && $auction->getISBN() !== null) {
            $textbook_query = null;
            if (strlen($auction->getISBN()) === 10) {
                $textbook_query = mysqli_query($link, "SELECT * FROM textbooks WHERE ISBN_v10='ISBN-10:{$auction->getISBN()}'");
            } else { // length of 13 for ISBNv13
                $textbook_query = mysqli_query($link, "SELECT * FROM textbooks WHERE ISBN_v13='ISBN-13:{$auction->getISBN()}'");
            }
            if ($textbook_query != null) {
                $textbook = null;
                while($row = mysqli_fetch_array($textbook_query)) {
                    $textbook = $row;
                }
            }
        }
        $_SESSION['AUCTION_TEXTBOOK'] = $textbook;
        $_SESSION['AUCTION_INFO'] = $auction;
        $_SESSION['AUCTION_BID'] = $highest_bid;
        
        mysqli_close($link);
        
    } else if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if (isset($_POST['bought']) && $_POST['bought']) {
            $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }
            
            $auction_ended = mysqli_real_escape_string($link, $_POST['bought']);
            $winner_username = mysqli_real_escape_string($link, $_POST['buyer']);
            
            $auction_query = mysqli_query($link, "UPDATE auctions SET auction_ended='1', winner_username='$winner_username' WHERE auction_id='{$_SESSION['AUCTION_INFO']->getAuctionId()}'");
            
            $_SESSION['AUCTION_INFO']->setAuctionEnded($auction_ended);
            $_SESSION['AUCTION_INFO']->setWinnerUserName($winner_username);
            
            mysqli_close($link);
//            header("Location: auctionInfo.php?auction_id={$_SESSION['AUCTION_INFO']->getAuctionId()}");
        }
        
    }
?>

        <nav class="profile-header">
            <a class="return" href="../auction/auctionSearch.php">&#10094; Return to Auction Search Page</a>
        <?php
            if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"]) {
                echo '<h1><a class="profile-name-link" href="../profile/profile.php">' . $_SESSION["displayname"] . '</a></h1>';
                echo '<a class="logout" href="../profile/logout.php">Not ' . $_SESSION["displayname"] . '? Logout.</a>';
            } else {
                header("Location: ../login/login.php");
            }
        ?>
        </nav>
        <section class="info">
            <h1>
                <?php
                    echo "Auction #" . $_SESSION['AUCTION_INFO']->getAuctionId() . " - " . $_SESSION["AUCTION_INFO"]->getAuctionTitle();
                ?>
            </h1>
            <h2>
                <?php
                    echo "Seller: " . $_SESSION['AUCTION_INFO']->getSellerDisplayName() . " (" . $_SESSION['AUCTION_INFO']->getSellerUserName() . ")";
                ?>
            </h2>
            <h2>
                <?php 
                    echo "Description: " . $_SESSION['AUCTION_INFO']->getAuctionDesc() . "<hr/>";
                ?>
            </h2>
            <h2>
                <?php
                    echo "Textbook for Sale:";
                ?>
            </h2>
            <ul>
                <?php
                    $textbook = $_SESSION["AUCTION_TEXTBOOK"];
                    if (!empty($textbook) && $textbook != null) {
                        echo '<li class="book-result custom-box-shadow">';
                        $thumbnail_url = "";
                        $lookup = BookLookup::runGoogleBooksRESTCall($_SESSION["AUCTION_INFO"]->getISBN());
                        if ($lookup['totalItems'] == 0) {
                            $lookup = null;
                            $thumbnail_url = "../assets/images/smallThumbnailPlaceholder.png";
                        } else if ($lookup != null) {
                            $thumbnail_url = BookLookup::returnSmallThumbnailURL($lookup);
                        }
                        echo '<img src="'.$thumbnail_url.'"/>';
                        echo '<aside><p>'.$textbook['Text_Name'].'</p>'; //book name
                        echo '<p>Author: ' . $textbook['Primary_Author'] . '</p>'; //book author
                    }
                ?>
                <?php $bid_display_price = ($_SESSION['AUCTION_INFO']->getStartBidPrice() < $_SESSION['AUCTION_BID']) ? $_SESSION['AUCTION_BID'] : $_SESSION['AUCTION_INFO']->getStartBidPrice(); 
                    if ($_SESSION['AUCTION_INFO']->getAuctionEnded()) {
                        if ($_SESSION['username'] === $_SESSION['AUCTION_INFO']->getSellerUserName()) {
                            echo '<p>Auction has ended. User '. $_SESSION['AUCTION_INFO']->getWinnerUserName() .' won the book.</p>';
                        } else {
                            echo '<p>Auction has ended.</p>';
                        }
                    } else {
                        echo '<p>Current Highest Bid: '.$bid_display_price.'</p>';
                        if ($_SESSION['username'] !== $_SESSION['AUCTION_INFO']->getSellerUserName()) {
                            echo '<form action="placeBid.php" method="POST">';
                            echo '<label for="new_bid">Place Bid:</label>';
                            echo '<input type="number" name="new_bid" min="'.$bid_display_price.'" step="0.01" max="500" value="'.$bid_display_price.'" name="new_bid"/>';
                            echo '<input class="submit-btn" type="submit" name="update_bid" value="Place Bid"></form>';
                            echo '<form action="auctionInfo.php" method="POST">';
                            echo '<label for="bin_price">Or, Buy-It-Now for '.$_SESSION['AUCTION_INFO']->getBINPrice().'</label>';
                            echo '<script
                                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                data-key="pk_test_SHZ2ku3SsJWVPUZkb2gMFCxn"
                                data-image="/img/documentation/checkout/marketplace.png"
                                data-name="BookSmart Auction Purchase"
                                data-description="'.$_SESSION["AUCTION_TEXTBOOK"]['Text_Name'].'"
                                data-amount="'.($_SESSION['AUCTION_INFO']->getBINPrice() * 100).'"
                                data-locale="auto">
                            </script>
                            <input name="bought" value="true" hidden/>
                            <input name="buyer" value="'.$_SESSION['username'].'" hidden/>';
                        }
                    }
                ?>
                
                <?php echo '</form></aside></li>'; ?>
            </ul>
        </section>
<?php require($INC_DIR . "footer.php"); ?>