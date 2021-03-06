<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require_once($INC_DIR. "header.php");
    session_start();
    if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"]) {
        header("Location: ../profile/profile.php");
    }
    if (!isset($_SESSION['registered'])) {
        if($_SERVER["REQUEST_METHOD"] == "GET") {
            $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }

            $confirm_code = mysqli_real_escape_string($link, $_GET['conf']);
            $query = mysqli_query($link, "SELECT * FROM temp_users WHERE confirmation_code='$confirm_code'"); //query users table

            $temp_user = null;
            if ($query !== null) {
                $temp_user = mysqli_fetch_array($query);
            }

            if ($temp_user != null) {
                $_SESSION['registered'] = true;
                 mysqli_query($link, "INSERT INTO users (username, password, displayname, email) VALUES ('{$temp_user['username']}','{$temp_user['password']}','{$temp_user['displayname']}','{$temp_user['email']}')");
                mysqli_query($link, "DELETE FROM temp_users WHERE confirmation_code='$confirm_code'");
                session_write_close();
            } else {
                echo "<section id='confirmed'><p>Confirmation unsuccessful. (Are you using the correct email link that was provided?)</p></section>";
            }
        } 
    }
    
?>
<?php
    if (isset($_SESSION['registered'])) {
        echo "<section id='confirmed'><p>Your account is succesfully registered!</p>";
        echo "<p>Please login <a href='login.php'>here</a>.</p></section>";
    }
?>
<?php require_once($INC_DIR. "footer.php");