<?php 
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['reset'])) {
            $_SESSION['AUCTION_POST_FIELDS'] = [];
            $_SESSION['AUCTION_RESULTS'] = [];
        } else if (isset($_POST['submit'])) {
            //Open connection to db and stay connected until closed
            $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }
            
            $text_name = mysqli_real_escape_string($link, $_POST['book']);

            $defaultQuery = "SELECT * FROM auctions WHERE text_name='$text_name'";
            $query = mysqli_query($link, $defaultQuery);
            if (isset($query) && $query !== null) {
                $searchResults = [];
                //Checks the database to see if any auctions match the query
                while($row = mysqli_fetch_array($query)) {
                    if (!in_array($row, $searchResults)) {
                        if (!$row['auction_ended']) {
                            array_push($searchResults, $row);
                        }
                    }
                }
//                var_dump($searchResults);
                $_SESSION["AUCTION_RESULTS"] = $searchResults;
                $_SESSION["AUCTION_BOOK_SELECTION"] = $text_name;  
//                var_dump
                header("Location: auctionSearch.php");
            }
            mysqli_close($link);
        }
        
    }
    session_write_close();
?>