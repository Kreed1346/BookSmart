<?php   
    //Open connection to db and stay connected until closed
    $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    $defaultQuery = "SELECT DISTINCT text_name, auction_ended FROM auctions ORDER BY text_name ASC";
    $query = mysqli_query($link, $defaultQuery);
//    var_dump($query);
    if (isset($query) && $query !== null) {
        $searchResults = [];
        //Checks the database to see if a user with the same username is found
        while($row = mysqli_fetch_array($query)) {
            if (!in_array($row, $searchResults)) {
                if (!$row['auction_ended']) {
                    array_push($searchResults, $row);
                }
            }
        }
        $_SESSION["AUCTION_PRE_RESULTS"] = $searchResults;
    }
//    $_SESSION["AUCTION_BOOK_SELECTION"] = null;
//    $_SESSION["AUCTION_PRE_RESULTS"] = []; //run this to reset the array
    mysqli_close($link);
    session_write_close();
?>