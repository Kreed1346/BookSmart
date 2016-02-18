<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    $SWIFT_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/dependencies/vendor/swiftmailer/swiftmailer/";
    require($INC_DIR. "header.php");
    session_start();
    if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"]) {
        header("Location: ../profile/profile.php");
    }
?>
        <section class="login-form">
            <br/>
            <a class="return" href="../home/index.php">&#10094; Return to Home</a>
            <h1>Register an account</h1>
            <form action="register.php" method="POST">
                <label for="username">Username: </label>
                <input type="text" name="username" required="required" placeholder="Enter something unique." required/>
                <br/>
                <label for="password">Password: </label>
                <input type="password" name="password" required="required" placeholder="Enter something secure." required/>
                <br/>
                <label for="displayname">Display Name: </label>
                <input type="text" name="displayname" placeholder="What name do you go by?"/>
                <br/>
                <label for="displayname">Email: </label>
                <input type="text" name="email" placeholder="Where can we contact you?" required/>
                <br/>
                <label for="displayname">Confirm Email: </label>
                <input type="text" name="confirm-email" placeholder="Double check that." required/>
                <br/>
                <input class="submit-btn" type="submit" name="submit" value="Register"/>
            </form>
        </section>
        
<?php require($INC_DIR. "footer.php"); ?>
<?php 
    require_once $SWIFT_DIR . 'lib/swift_required.php';
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
        
        $hashPass = password_hash($password, PASSWORD_BCRYPT);//, $options); is this breaking it?
        
        $user_query = mysqli_query($link, "SELECT * FROM users"); //query users table
        
        //Checks the database to see if a user with the same username is found
        while($row = mysqli_fetch_array($user_query)) {
            $table_user = $row['username'];
            //if the user to be inputed's username matches one already in the db
            if($username === $table_user) {
                //make sure the user with a duplicate name cannot be added to the db
                $uniqueUser = false;
                Print '<script>alert("Username is already taken.");</script>';
                header("Location: register.php");
            }
        }
        
        if ($uniqueUser) {
            $temp_user_query = mysqli_query($link, "SELECT * FROM temp_users"); //query users table

            //Checks the database to see if a user with the same username is found
            while($row = mysqli_fetch_array($temp_user_query)) {
                $table_user = $row['username'];
                //if the user to be inputed's username matches one already in the db
                if($username === $table_user) {
                    //make sure the user with a duplicate name cannot be added to the db
                    $uniqueUser = false;
                    Print '<script>alert("Username is already taken.");</script>';
                    header("Location: register.php");
                }
            }
        }
        
        //if the username isn't already in the database and the email fields match, create and add a new user, logging them in
        if($uniqueUser && $sameEmail) {
            $confirm_code = md5(uniqid(rand()));
            mysqli_query($link, "INSERT INTO temp_users (confirmation_code, username, password, displayname, email) VALUES ('$confirm_code','$username','$hashPass','$displayname','$confirmEmail')");
            
            $transport = Swift_SmtpTransport::newInstance('localhost', 25);
            $body = "<html><body><p>Thanks for signing up with BookSmart! Please activate your account by clicking through the link located <a href='http://localhost/BookSmart/root/login/registrySuccess.php?conf=$confirm_code'>here</a>.</p></body></html>";
            $mailer = Swift_Mailer::newInstance($transport);
            $message = Swift_Message::newInstance('BookSmart Registration Confirmation')
                ->setFrom(array('kurtreed1346@gmail.com'=>'BookSmart Administrator'))
                ->setTo(array($confirmEmail => $displayname))
                ->setBody($body, 'text/html');
            
            $result = $mailer->send($message);
            header("Location: ../login/confirmAccount.php");
            session_write_close();
        }
        
        //Close db connection
        mysqli_close($link);
    }
?>