<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require($INC_DIR . "header.php");
    session_start();
?>
        <nav class="profile-header">
        <?php
            if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"]) {
                echo '<h1>Welcome, ' . $_SESSION["displayname"] . '</h1>';
                echo '<a href="logout.php">Not ' . $_SESSION["displayname"] . '? Logout.</a>';
            } else {
                Print '<script>window.location.assign("../login/login.php");</script>';
            }
        ?>
        </nav>
        <aside class="resource-sidebar">
            <h1>Resources</h1>
            <hr/>
            <h2><a href="../courses/search.php">Search for Courses</a></h2>
            <h2><a href="profile-settings.php">Change Profile Settings</a></h2>
        </aside>
<?php require($INC_DIR . "footer.php"); ?>