<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    session_start();
    require($INC_DIR . "header.php");
    require($INC_DIR . "top-navbar.php");
?>
        <?php
            if (isset($_SESSION['UPDATED']) && $_SESSION['UPDATED']) {
                echo "<div class='update-notif'><h1>Profile updated!</h1></div>";
                $_SESSION['UPDATED'] = false;
            }
        ?>
        <section id="profile-settings">
            <br/>
            <a class="return" href="../profile/profile.php">&#10094; Return to Profile Page</a>
            <h1>Profile Settings</h1>
            <form action="changeSettings.php" method="POST">
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