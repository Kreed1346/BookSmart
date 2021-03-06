<?php   
    //Open connection to db and stay connected until closed
    $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    $defaultQuery = "SELECT DISTINCT Course_Code, Course_Desc FROM courses ORDER BY Course_Code ASC";// WHERE ";
    $query = mysqli_query($link, $defaultQuery);

    if (isset($query)) {
        $searchResults = [];
        //Checks the database to see if a user with the same username is found
        while($row = mysqli_fetch_array($query)) {
            if (!in_array($row, $searchResults)) {
                array_push($searchResults, $row);
            }
        }
        $_SESSION["SEARCH_RESULTS"] = $searchResults;
    }
    mysqli_close($link);
    session_write_close();
?>