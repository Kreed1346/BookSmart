<nav class="profile-header">
    <aside>
        <img src="../assets/images/booksmart-logo.png"/>
        <p>ookSmart</p>
    </aside>
<?php
    if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"]) {
        echo '<h1><a class="profile-name-link" href="../profile/profile.php">' . $_SESSION["displayname"] . '</a></h1>';
        echo '<a class="logout" href="../profile/logout.php">Not ' . $_SESSION["displayname"] . '? Logout.</a>';
    } else {
        header("Location: ../login/login.php");
    }
?>
</nav>