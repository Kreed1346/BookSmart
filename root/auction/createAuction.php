<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    session_start();
    require($INC_DIR . "header.php");
    require($INC_DIR . "top-navbar.php");
    require 'bookSearch.php';
?>
        
        <section id="auction">
            <br/>
            <a class="return" href="../auction/auctionLanding.php">&#10094; Return to Auction Landing Page</a>
            <h1>Create an Auction Listing</h1>
            <form action="validateAuctionCreation.php" method="POST">
                <label for="auctionTitle">Auction Title</label><br/>
                <input type="text" name="auctionTitle" placeholder="Enter auction title here." required/><br/>
                <label for="auctionDesc">Auction Description</label><br/>
                <textarea name="auctionDesc" rows="4" cols="50" placeholder="Enter auction description here." required></textarea><br/>
                <label for="book">Book for Sale</label><br/>
                <select name="book" required>
                    <option value="">Please select a book</option>
                    <?php
                        if (isset($_SESSION["BOOK_RESULTS"])) {
                            foreach ($_SESSION["BOOK_RESULTS"] as $book) {
                                $value = !empty($book["ISBN_v10"]) ? substr($book["ISBN_v10"], 8, 10) : substr($book["ISBN_v13"], 8, 13);
                                $name = $book["Text_Name"];
                                echo "<option value='$value'>$name</option>";
                            }
                        }
                    ?>
                </select><br/>
                <label for="bin_price">Buy-It-Now Price</label><br/>
                <input type="number" min="0.01" step="0.01" max="500" value="0.01" name="bin_price"/><br/>
                <label for="start_bid_price">Starting Bid Price</label><br/>
                <input type="number" min="0.01" step="0.01" max="500" value="0.01" name="start_bid_price"/><br/>
                <input class="submit-btn" type="submit" name="submit" value="Submit">
            </form>
        </section>
<?php require($INC_DIR . "footer.php"); ?>