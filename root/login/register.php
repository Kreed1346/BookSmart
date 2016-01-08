<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
require($INC_DIR. "header.php");
    session_start();
    if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"]) {
        Print '<script>window.location.assign("../profile/profile.php");</script>';
    }
?>
        <section class="login-form">
            <h1>Register an account</h1>
            <a class="return" href="../home/index.php">Return to Home</a>
            <form action="register.php" method="POST">
                <label for="username">Username: </label>
                <input type="text" name="username" required="required" placeholder="Enter username here."/>
                <br/>
                <label for="password">Password: </label>
                <input type="password" name="password" required="required" placeholder="Enter password here."/>
                <br/>
                <label for="displayname">Display Name: </label>
                <input type="text" name="displayname" placeholder="Choose a display name here."/>
                <br/>
                <input class="submit-btn" type="submit" name="submit" value="Register"/>
            </form>
        </section>
        
<?php require($INC_DIR. "footer.php"); ?>
<?php 
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        
        $username = mysqli_real_escape_string($link, $_POST['username']); //sanitize username input
        $password = mysqli_real_escape_string($link, $_POST['password']); //sanitize password input
        $displayname = mysqli_real_escape_string($link, $_POST['displayname']); //sanitize displayname input
        $bool = true;
        
//        mysqli_connect("localhost", "root", "") or die(mysql_error()); //Open connection
//        mysqli_select_db("booksmart") or die("Cannot connect to database"); //Connect to db
        $query = mysqli_query($link, "SELECT * FROM users"); //query users table
        
        //Checks the database to see if a user with the same username is found
        while($row = mysqli_fetch_array($query)) {
            $table_user = $row['username'];
            //if the user to be inputed's username matches one already in the db
            if($username == $table_user) {
                //make sure the user with a duplicate name cannot be added to the db
                $bool = false;
                Print '<script>alert("Username is already taken.");</script>';
                Print '<script>window.location.assign("register.php");</script>';
            }
        }
        
        //if the username isn't already in the database, create and add a new user, logging them in
        if($bool) {
            mysqli_query($link, "INSERT INTO users (username, password, displayname) VALUES ('$username','$password','$displayname')");
            Print '<script>window.location.assign("../profile/profile.php");</script>';
            if (!empty($displayname)) {
                $_SESSION["displayname"] = $displayname;
            } else {
                $_SESSION["displayname"] = $username;
            }
            $_SESSION["isLoggedIn"] = true;
            session_write_close();
        }
        mysqli_close($link);
    }
?>