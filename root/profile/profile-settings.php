<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require($INC_DIR . "header.php");
    session_start();
?>
        <nav class="profile-header">
        <?php
            if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"]) {
                echo '<h1>' . $_SESSION["displayname"] . '</h1>';
                echo '<a href="logout.php">Not ' . $_SESSION["displayname"] . '? Logout.</a>';
            } else {
                Print '<script>window.location.assign("../login/login.php");</script>';
            }
        ?>
        </nav>
        <?php
            if (isset($_SESSION['UPDATED']) && $_SESSION['UPDATED']) {
                echo "<div class='update-notif'><h1>Profile updated!</h1></div>";
                $_SESSION['UPDATED'] = false;
            }
        ?>
        <section id="profile-settings">
            <h1>Profile Settings</h1>
            <a class="return" href="../profile/profile.php">Return to Profile Page</a>
            <form action="change-settings.php" method="POST">
                <label for="displayname">Display Name: </label>
                <input type="text" name="displayname" placeholder="Choose a display name here." value="<?php echo $_SESSION['displayname']?>"/>
                <br/>
                <label for="newPassword">New Password: </label>
                <input type="password" name="newPassword" placeholder="Enter new password here."/>
                <br/>
                <label for="confirmPassword">Confirm New Password: </label>
                <input type="password" name="confirmPassword" placeholder="Re-enter new password here."/>
                <br/>
                <input class="submit-btn" type="submit" name="submit" value="Update Profile"/>
            </form>
        </section>
<?php require($INC_DIR . "footer.php"); ?>