<?php   
    //Open connection to db and stay connected until closed
    $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    $defaultQuery = "SELECT Text_Name, ISBN_v10, ISBN_v13 FROM textbooks ORDER BY Text_Name ASC";
    $query = mysqli_query($link, $defaultQuery);

    if (isset($query) && $query !== null) {
        $searchResults = [];
        //Checks the database to see if a user with the same username is found
        while($row = mysqli_fetch_array($query)) {
            if (!in_array($row, $searchResults)) {
                array_push($searchResults, $row);
            }
        }
//        var_dump($searchResults);
        $_SESSION["BOOK_RESULTS"] = $searchResults;
    }
//    $_SESSION["BOOK_RESULTS"] = []; //run this to reset the array
    mysqli_close($link);
    session_write_close();
?>