<nav class="profile-header">
    <aside>
        <a href="../profile/profile.php">
            <?php
                if (file_exists("../assets/images/booksmart-logo.png")) {
                    echo '<img src="../assets/images/booksmart-logo.png"/>';
                } else {
                    echo '<img src="../../assets/images/booksmart-logo.png"/>';
                }
            ?>
            <p>ookSmart</p>
        </a>
    </aside>
<?php
    if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"]) {
        if (file_exists("../profile/profile.php")) {
            echo '<h1><a class="profile-name-link" href="../profile/profile.php">' . $_SESSION["displayname"] . '</a></h1>';
            echo '<a class="logout" href="../profile/logout.php">Not ' . $_SESSION["displayname"] . '? Logout.</a>';
            echo '<a class="settings" href="../profile/profileSettings.php"><img src="../assets/images/settings-gear-light.png"/></>';
        } else {
            echo '<h1><a class="profile-name-link" href="../../profile/profile.php">' . $_SESSION["displayname"] . '</a></h1>';
            echo '<a class="logout" href="../../profile/logout.php">Not ' . $_SESSION["displayname"] . '? Logout.</a>';
            echo '<a class="settings" href="../../profile/profileSettings.php"><img src="../../assets/images/settings-gear-light.png"/></>';
        }
    } else {
        header("Location: ../login/login.php");
    }
?>
</nav>