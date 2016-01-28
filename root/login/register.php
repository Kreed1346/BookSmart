<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require($INC_DIR. "header.php");
    session_start();
    if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"]) {
        header("Location: ../profile/profile.php");
    }
?>
        <section class="login-form">
            <h1>Register an account</h1>
            <a class="return" href="../home/index.php">Return to Home</a>
            <form action="register.php" method="POST">
                <label for="username">Username: </label>
                <input type="text" name="username" required="required" placeholder="Enter username here." required/>
                <br/>
                <label for="password">Password: </label>
                <input type="password" name="password" required="required" placeholder="Enter password here." required/>
                <br/>
                <label for="displayname">Display Name: </label>
                <input type="text" name="displayname" placeholder="Choose a display name here."/>
                <br/>
                <label for="displayname">Email: </label>
                <input type="text" name="email" placeholder="Enter your email here." required/>
                <br/>
                <label for="displayname">Confirm Email: </label>
                <input type="text" name="confirm-email" placeholder="Confirm your email here." required/>
                <br/>
                <input class="submit-btn" type="submit" name="submit" value="Register"/>
            </form>
        </section>
        
<?php require($INC_DIR. "footer.php"); ?>
<?php 
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        //Open connection to db and stay connected until closed
        $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        
        $username = mysqli_real_escape_string($link, $_POST['username']); //sanitize username input
        $password = mysqli_real_escape_string($link, $_POST['password']); //sanitize password input
        $displayname = mysqli_real_escape_string($link, $_POST['displayname']); //sanitize displayname input
        $email = mysqli_real_escape_string($link, $_POST['email']); //sanitize email input
        $confirmEmail = mysqli_real_escape_string($link, $_POST['confirm-email']); //sanitize email confirmation input
        $uniqueUser = true;
        $sameEmail = true;
        
        if (empty($email)) { //email field empty, required
            Print '<script>alert("Email field is empty, required.");</script>';
            $sameEmail = false;
            header("Location: register.php");
        } else if (!empty($email) && empty($confirmEmail)) { //email isn't empty, but confirmation field is
            Print '<script>alert("Email field is filled, but email confirmation field is empty, required.");</script>';
            $sameEmail = false;
            header("Location: register.php");
        } else if (!empty($email) && !empty($confirmEmail)) { //if both email fields are filled 
            if ($email != $confirmEmail) { //but don't match
                Print '<script>alert("Email fields do not match.");</script>';
                $sameEmail = false;
                header("Location: register.php");
            } else {
                //all is good!
            }
        }
        
//        $options = [
//            'cost' => 11,
//            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
//        ];

        $hashPass = password_hash($password, PASSWORD_BCRYPT);//, $options); is this breaking it?
        
        $query = mysqli_query($link, "SELECT * FROM users"); //query users table
        
        //Checks the database to see if a user with the same username is found
        while($row = mysqli_fetch_array($query)) {
            $table_user = $row['username'];
            //if the user to be inputed's username matches one already in the db
            if($username === $table_user) {
                //make sure the user with a duplicate name cannot be added to the db
                $uniqueUser = false;
                Print '<script>alert("Username is already taken.");</script>';
                header("Location: register.php");
            }
        }
        
        //if the username isn't already in the database and the email fields match, create and add a new user, logging them in
        if($uniqueUser && $sameEmail) {
            mysqli_query($link, "INSERT INTO users (username, password, displayname, email) VALUES ('$username','$hashPass','$displayname','$confirmEmail')");
            header("Location: ../profile/profile.php");
            if (!empty($displayname)) {
                $_SESSION["displayname"] = $displayname;
            } else {
                $_SESSION["displayname"] = $username;
            }
            $_SESSION["username"] = $username;
            $_SESSION["isLoggedIn"] = true;
            session_write_close();
        }
        
        //Close db connection
        mysqli_close($link);
    }
?>