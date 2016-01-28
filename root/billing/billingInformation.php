<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require($INC_DIR . "header.php");
    session_start();
?>
        <nav class="profile-header">
            <a class="return" href="../profile/profile.php">&#10094; Return to Profile Page</a>
        <?php
            if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"]) {
                echo '<h1><a class="profile-name-link" href="../profile/profile.php">' . $_SESSION["displayname"] . '</a></h1>';
                echo '<a class="logout" href="../profile/logout.php">Not ' . $_SESSION["displayname"] . '? Logout.</a>';
            } else {
                Print '<script>window.location.assign("../login/login.php");</script>';
            }
        ?>
        </nav>
        <?php
            if (isset($_SESSION['CARD_CREATED']) && $_SESSION['CARD_CREATED']) {
                echo "<div class='update-notif'><h1>Card added!</h1></div>";
                $_SESSION['CARD_CREATED'] = false;
            }
        ?>
        <section class="cc-content">
            <h1>Billing Information</h1>
            <hr/>
            <h2><a href="addCard.php">Add a Credit Card</a></h2>
            <h2><a href="storedCards.php">View Stored Credit Cards</a></h2>
        </section>
<?php require($INC_DIR . "footer.php"); ?>