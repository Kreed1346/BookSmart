<?php 
    require_once '../profile/user.php';
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
        $user_pass = '';
        $user_displayname = "";
        
        $user = null;
        if ($exists > 0 && $exists == 1) {
            
            while ($row = mysqli_fetch_assoc($query)) {
                $user_name = $row['username'];
                $user_pass = $row['password'];
                $user_displayname = $row['displayname'];
                
                $user = new User($user_name, $user_displayname, $row['email']);

                if ($row['moderator']) {
                    $user->setModStatus();
                }
                
                if ($row['administrator']) {                    
                    $user->setAdminStatus();                    
                }
                var_dump($user);
            }
            
            if($username == $user_name) {
                if (password_verify($password, $user_pass)) {
                    $accurateLoginInfo = true;
                }
                Print '<script>window.alert("Password Verification is failing")</script>';
            }
            
        }
        
        //if the user's username and password are found in the db and found to be accurate, log them in
        if($accurateLoginInfo) {
            
            if (!empty($user_displayname)) {
                $_SESSION["displayname"] = $user_displayname;
            } else {
                $_SESSION["displayname"] = $username;
            }
            $_SESSION["username"] = $username;
            
            if ($user !== null) {
                $_SESSION["USER_INFO"] = $user;
            }
            
            $_SESSION["isLoggedIn"] = true;
            
            if ($user->getAdminStatus() || $user->getModStatus()) {
                if ($user->getAdminStatus()) {
                    header("Location: ../admin/adminHome.php");
                } else {
                    header("Location: ../mod/modHome.php");
                }
            } else {
                header("Location: ../profile/profile.php");
            }
        } else {
            header("Location: login.php");
        }
        mysqli_close($link);
    }
?>