<?php 
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        
        $username = mysqli_real_escape_string($link, $_POST['username']); //sanitize username input
        $password = mysqli_real_escape_string($link, $_POST['password']); //sanitize password input
        $accurateLoginInfo = false;
        
//        mysqli_connect("localhost", "root", "") or die(mysql_error()); //Open connection
//        mysqli_select_db("booksmart") or die("Cannot connect to database"); //Connect to db
        $query = mysqli_query($link, "SELECT * FROM users WHERE username = '$username'"); //query users table
        $exists = mysqli_num_rows($query);
        $user_name = "";
        $user_pass = "";
        $user_displayname = "";
        if ($exists > 0 && $exists == 1) {
            
            while ($row = mysqli_fetch_assoc($query)) {
                $user_name = $row['username'];
                $user_pass = $row['password'];
                $user_displayname = $row['displayname'];
            }
            
            if(($username == $user_name) && ($password == $user_pass)) {
                $accurateLoginInfo = true;
            } 
        }
        
        //if the user's username and password are found in the db and found to be accurate, log them in
        if($accurateLoginInfo) {
            
            if (!empty($user_displayname)) {
                $_SESSION["displayname"] = $user_displayname;
            } else {
                $_SESSION["displayname"] = $username;
            }
            $_SESSION["isLoggedIn"] = true;
            
            header("location: ../profile/profile.php");
        } else {
            Print '<script>window.location.assign("login.php");</script>';
        }
        mysqli_close($link);
    }
?>