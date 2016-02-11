<?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST['course'])) {
            $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }
            
            $courseID = mysqli_real_escape_string($link, $_POST['course']); //sanitize courseID input
            header("Location: courseInfo.php?courseID=$courseID");
        }
    }
?>