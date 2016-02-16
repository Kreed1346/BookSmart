<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    session_start();
    require($INC_DIR . "header.php");
    require($INC_DIR . "top-navbar.php");
    require 'auctionPresearch.php';
?>
        <section class="search-form">
            <br/>
            <a class="return" href="../auction/auctionLanding.php">&#10094; Return to Auction Landing Page</a>
            <h1>Search for Auctions by Textbook</h1>
<!--
            <section class="sub-text">
                <p>Provide at least one field with information</p>
                <p>(More fields filled provides the best results)</p>
            </section>
-->
            <form action="validateAuctionSearch.php" method="POST">
<!--                <label for="book" class="search-label">Books Currently Being Auctioned Off: </label><br/>-->
                <select name="book" required>
                    <option value="">Please select a book</option>
                    <?php
                        if (isset($_SESSION["AUCTION_PRE_RESULTS"])) {
                            foreach ($_SESSION["AUCTION_PRE_RESULTS"] as $book) {
                                $value = $book["text_name"];
                                if (isset($_SESSION["AUCTION_BOOK_SELECTION"]) && $_SESSION["AUCTION_BOOK_SELECTION"] === $value) {
                                    echo "<option value='$value' selected>$value</option>";
                                } else {
                                    echo "<option value='$value'>$value</option>";
                                }
                            }
                        }
                    ?>
                </select><br/>
                <input class="submit-btn" type="submit" name="submit" value="Search"/>
<!--                <input class="submit-btn" type="submit" name="reset" value="Reset Search Fields"/>-->
            </form>
        </section>
        <section id="search-results">
            <?php 
                if (isset($_SESSION["AUCTION_RESULTS"])) {
                    if (!empty($_SESSION["AUCTION_RESULTS"])) {
                        $count = count($_SESSION["AUCTION_RESULTS"]);
                        $string = $count . ($count . ($count > 1) ? " results" : " result") . " found.";
                        echo "<p>" . $string . "</p>";
                        foreach($_SESSION["AUCTION_RESULTS"] as $searchResult) {
                            echo "<a href='auctionInfo.php?auction_id={$searchResult['auction_id']}'><p class='search-result'>Auction #$searchResult[0]: - $searchResult[1]</p></a>";
                        }
                    } else {
                        echo "<p>No auctions found matching the search parameters.</p>";
                    }
                } else {
                    echo "<p>A search has not been ran yet.</p>";
                }
                
            ?>
        </section>
<?php require($INC_DIR . "footer.php"); ?>
