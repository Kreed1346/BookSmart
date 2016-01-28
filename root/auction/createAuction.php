<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require($INC_DIR . "header.php");
    session_start();
?>
        <nav class="profile-header">
            <a class="return" href="../auction/auctionLanding.php">&#10094; Return to Auction Landing Page</a>
        <?php
            if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"]) {
                echo '<h1><a class="profile-name-link" href="../profile/profile.php">' . $_SESSION["displayname"] . '</a></h1>';
                echo '<a class="logout" href="logout.php">Not ' . $_SESSION["displayname"] . '? Logout.</a>';
            } else {
                header("../login/login.php");
            }
        ?>
        </nav>
        <section id="auction">
            <h1>Create an Auction Listing</h1>
            <form action="createAuction.php" method="POST">
                <label for="auctionTitle">Auction Title</label>
                <input type="text" name="auctionTitle" placeholder="Enter auction title here." required/><br/>
                <label for="auctionDesc">Auction Description</label>
                <textarea rows="4" cols="50" placeholder="Enter auction description here." required></textarea><br/>
                <label for="isbn">ISBN of Book for Sale</label>
                <input class="cvv" type="text" name="isbn" pattern="[0-9]{10,13}" required><br/>
                <label for="bin_price">Buy-It-Now Price</label>
                <input type="number" min="0.01" step="0.01" max="500" value="0.01" name="bin_price"/><br/>

                <input class="submit-btn" type="submit" name="submit" value="Submit">
            </form>
        </section>
<?php require($INC_DIR . "footer.php"); ?>