<?php 
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        //Open connection to db and stay connected until closed
        $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        
        $displayname = mysqli_real_escape_string($link, $_POST['displayname']); //sanitize displayname input
        $newPass = mysqli_real_escape_string($link, $_POST['newPassword']); //sanitize new password input
        $confirmPass = mysqli_real_escape_string($link, $_POST['confirmPassword']); //sanitize password confirmation input
        
        $user_check = $_SESSION['username'];
        $query = mysqli_query($link, "SELECT * FROM users WHERE username='$user_check'");

        if ($query != null) {
            $user;
            //Checks the database to see if a user with the stored username is found
            while($row = mysqli_fetch_array($query)) {
                $user = $row;
            }

            if ($displayname != $user['displayname']) {
                mysqli_real_query($link, "UPDATE users SET displayname='$displayname' WHERE username='$user_check'");
                $_SESSION["displayname"] = $displayname;
                $_SESSION['UPDATED'] = true;
            }
                             
            if (!empty($newPass) && !empty($confirmPass) && $newPass == $confirmPass) { // SALT/HASH password at a later date
                $hashPass = password_hash($confirmPass, PASSWORD_BCRYPT);//, $options); is this breaking it?
                mysqli_real_query($link, "UPDATE users SET password='$hashPass' WHERE username='$user_check'");
                $_SESSION['UPDATED'] = true;
            }
            header("Location: profileSettings.php");
        }
        mysqli_close($link);
    }
?>