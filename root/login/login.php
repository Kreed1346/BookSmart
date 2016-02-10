<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require($INC_DIR. "header.php");
    session_start();
    if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"]) {
        header("Location: ../profile/profile.php");
    }
?>
        <section class="login-form">
            <h1>Login to your account</h1>
            <a class="return" href="../home/index.php">&#10094; Return to Home</a>
            <form action="login.php" method="POST">
                <label for="username">Username: </label>
                <input type="text" name="username" required="required" placeholder="Enter username here."/>
                <br/>
                <label for="password">Password: </label>
                <input type="password" name="password" required="required" placeholder="Enter password here."/>
                <br/>
                <input class="submit-btn" type="submit" name="submit" value="Login"/>
            </form>
        </section>
<?php require($INC_DIR. "footer.php"); ?>
<?php
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
        $user_pass = '';
        $user_displayname = "";
        if ($exists > 0 && $exists == 1) {
            while ($row = mysqli_fetch_assoc($query)) {
                $user_name = $row['username'];
                $user_pass = $row['password'];
                $user_displayname = $row['displayname'];
            }
            
            if($username == $user_name) {
                if (password_verify($password, $user_pass)) {
                    $accurateLoginInfo = true;
                }
            }
        }
        
        //if the user's username and password are found in the db and found to be accurate, log them in
        if($accurateLoginInfo && $_SESSION['registered']) {
            
            if (!empty($user_displayname)) {
                $_SESSION["displayname"] = $user_displayname;
            } else {
                $_SESSION["displayname"] = $username;
            }
            $_SESSION["username"] = $username;
            $_SESSION["isLoggedIn"] = true;
            
            header("Location: ../profile/profile.php");
        } else {
            header("Location: login.php");
        }
        mysqli_close($link);
    }


?>