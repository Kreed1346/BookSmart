<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require($INC_DIR . "header.php");
    session_start();
?>
        <nav class="profile-header">
            <a class="return" href="../auction/auctionLanding.php">&#10094; Return to Auction Landing Page</a>
        <?php
            if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"]) {
                echo '<h1><a class="profile-name-link" href="../profile/profile.php">' . $_SESSION["displayname"] . '</a></h1>';
                echo '<a class="logout" href="logout.php">Not ' . $_SESSION["displayname"] . '? Logout.</a>';
            } else {
                header("../login/login.php");
            }
        ?>
        </nav>
        <section class="search-form">
            <h1>Search for an Auction</h1>
            <section class="sub-text">
                <p>Provide at least one field with information</p>
                <p>(More fields filled provides the best results)</p>
            </section>
            <form action="auctionSearch.php" method="POST">
                <label for="auctionID" class="search-label">Auction ID: </label>
                <input type="text" name="auctionID" placeholder="Enter your the Auction ID" value="<?php if(isset($_SESSION["AUCTION_POST_FIELDS"]['auctionID'])){echo $_SESSION["AUCTION_POST_FIELDS"]['auctionID'];}?>"/>
                <br/>
                <label for="auctionName" class="search-label">Auction Title: </label>
                <input type="text" name="auctionName" placeholder="Enter the auction title" value="<?php if(isset($_SESSION["AUCTION_POST_FIELDS"]['auctionName'])){echo $_SESSION["AUCTION_POST_FIELDS"]['auctionName'];}?>"/>
                <br/>
                <label for="auctionDesc" class="search-label">Auction Description: </label>
                <input type="text" name="auctionDesc" placeholder="Enter part/all of the auction description" value="<?php if(isset($_SESSION["AUCTION_POST_FIELDS"]['auctionDesc'])){echo $_SESSION["AUCTION_POST_FIELDS"]['auctionDesc'];}?>"/>
                <br/>
                <label for="isbn" class="search-label">Book ISBN: </label>
                <input type="text" name="isbn" placeholder="Enter the isbn of the book being auctioned off" value="<?php if(isset($_SESSION["AUCTION_POST_FIELDS"]['isbn'])){echo $_SESSION["AUCTION_POST_FIELDS"]['isbn'];}?>"/>
                <br/>
                <input class="submit-btn" type="submit" name="submit" value="Search"/>
                <input class="submit-btn" type="submit" name="reset" value="Reset Search Fields"/>
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
<?php 
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['reset'])) {
            $_SESSION['AUCTION_POST_FIELDS'] = [];
            $_SESSION['AUCTION_RESULTS'] = [];
            header("Location: auctionSearch.php");
        } else if (isset($_POST['submit'])) {
            //Open connection to db and stay connected until closed
            $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }
            $postFields = [
                "auctionID"=>mysqli_real_escape_string($link, $_POST['auctionID']),
                "auctionName"=>mysqli_real_escape_string($link, $_POST['auctionName']),
                "auctionDesc"=>mysqli_real_escape_string($link, $_POST['auctionDesc']),
                "isbn"=>mysqli_real_escape_string($link, $_POST['isbn'])
            ];
            $_SESSION['AUCTION_POST_FIELDS'] = $postFields;

            $defaultQuery = "SELECT * FROM auctions WHERE ";
            $queryString = $defaultQuery; //Query the auctions 
            $andBool = false; //If true, start using AND before concatenating query portions
            foreach($postFields as $postFieldKey => $postFieldValue) {
                if (!empty($postFieldValue)) {
                    if ($andBool) {
                        $queryString .= " AND ";
                    }
                    switch($postFieldKey) {
                        case "auctionID":
                            $queryString .= "auction_id ";
                            break;
                        case "auctionName":
                            $queryString .= "auction_title ";
                            break;
                        case "auctionDesc":
                            $queryString .= "auction_desc ";
                            break;
                        case "isbn":
                            $queryString .= "isbn ";
                            break;
                    }
                    $queryString .= "LIKE '%{$postFieldValue}%'";
                    if ($andBool === false) {
                        $andBool = true;
                    }
                }
            }

            if ($queryString === $defaultQuery) {
                Print '<script>alert("Please fill at least one field before searching.");</script>';
                header("Location: auctionSearch.php");
                $_SESSION["AUCTION_RESULTS"] = [];
            }

            $query = mysqli_query($link, $queryString);
            if (isset($query)) {
                $searchResults = [];
                //Checks the database to see if any auctions match the query
                while($row = mysqli_fetch_array($query)) {
                    if (!in_array($row, $searchResults)) {
                        array_push($searchResults, $row);
                    }
                }
                $_SESSION["AUCTION_RESULTS"] = $searchResults;
                header("Location: auctionSearch.php");
            }
            mysqli_close($link);
        }
    }
?>