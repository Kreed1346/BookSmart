<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
require($INC_DIR. "header.php");
    session_start();
    if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"]) {
        Print '<script>window.location.assign("../profile/profile.php");</script>';
    }
?>
        <h1>Login to your account</h1>
        <a href="../home/index.php">Return to Home</a>
        <form action="validateLogin.php" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" required="required" placeholder="Enter username here."/>
            <br/>
            <label for="password">Password</label>
            <input type="password" name="password" required="required" placeholder="Enter password here."/>
            <br/>
            <input type="submit" name="submit" value="Login"/>
        </form>
<?php require($INC_DIR. "footer.php"); ?>