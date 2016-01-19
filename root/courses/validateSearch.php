<?php 
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        //Open connection to db and stay connected until closed
        $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        
        $courseID = mysqli_real_escape_string($link, $_POST['courseID']); //sanitize courseID input
        $courseName = mysqli_real_escape_string($link, $_POST['courseName']); //sanitize courseName input
        
        $query; //Query the courses table
        if (!empty($courseID) && !empty($courseName)) { //if both search fields are filled
            $query = mysqli_query($link, "SELECT * FROM courses WHERE Course_Code LIKE'%{$courseID}%' AND Course_Desc LIKE '%{$courseName}%'");
        } else if (!empty($courseID) && empty($courseName)) { //if courseID field is filled, but courseName field is not
            $query = mysqli_query($link, "SELECT * FROM courses WHERE Course_Code LIKE'%{$courseID}%'");
        } else if (empty($courseID) && !empty($courseName)) { //if courseID field is not filled, but courseName field is
            $query = mysqli_query($link, "SELECT * FROM courses WHERE Course_Desc LIKE '%{$courseName}%'");
        } else { //both fields are empty
            Print '<script>alert("Please fill at least one field before searching.");</script>';
            Print '<script>window.location.assign("../courses/search.php");</script>';
            $_SESSION["SEARCH_RESULTS"] = [];
        }
        
        if (isset($query)) {
            $searchResults = [];
            //Checks the database to see if a user with the same username is found
            while($row = mysqli_fetch_array($query)) {
                if (!in_array($row, $searchResults)) {
                    array_push($searchResults, $row);
                }
            }
            $_SESSION["SEARCH_RESULTS"] = $searchResults;
            Print '<script>window.location.assign("../courses/search.php");</script>';
        }
        mysqli_close($link);
    }
?>