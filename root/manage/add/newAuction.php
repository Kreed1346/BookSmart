<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require '../../profile/user.php';
    session_start();
    require($INC_DIR . "header.php");
    require($INC_DIR . "top-navbar.php");
    if (!$_SESSION['USER_INFO']->getAdminStatus()) {
        if (!$_SESSION['USER_INFO']->getModStatus()) {
            header("Location: ../profile/profile.php");
        }
    }

    $textbooks = [];
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        
        $textbook_query = mysqli_query($link, "SELECT * FROM textbooks");
        while ($row = mysqli_fetch_array($textbook_query)) {
            array_push($textbooks, $row);
        }
		
		$user_query = mysqli_query($link, "SELECT * FROM users WHERE username='".$_SESSION['USER_INFO']->getUsername()."'");
		$user_id = mysqli_fetch_array($user_query)['id'];
    }
?>
    <section>
        <section class="midbar db-tools-sidebar">
            <br/>
            <a class="return" href="../auctions.php">&lsaquo; Return to Course Catalog</a>
            <h1>Create an Auction</h1>
            <section>
                <form action="../validate/validateAuction.php" method="POST" class="db-form">
                    <input type="hidden" name="db-operator" value="add"/>
					<input type="hidden" name="auctioneer_id" value="<?php echo $user_id; ?>" />
                    <label for="title">Title:</label>
                    <input type="text" name="title" placeholder="Enter a title" required/>
                    <br/><br/>
                    <label for="description">Description:</label>
                    <input type="text" name="description" placeholder="Enter a description" required/>
                    <br/><br/>
					<label>Textbook for Sale</label>
                    <section class="book-selection">
                        <aside>
                            <select name="textbook" required>
                                <option value="">Please Choose a Textbook</option>
                                <?php
                                    foreach ($textbooks as $book) {
                                        $id = $book['id'];
                                        $value = $book["Text_Name"];
                                        echo "<option value='$id'>$value</option>";
                                    }
                                ?>
                            </select>
                        </aside>
                    </section>
					<label for="bin_price">Buy-It-Now Price: </label>
					<input type="number" min="0.01" step="0.01" max="500" value="0.01" name="bin_price" required/><br/><br/>
					<label for="start_bid_price">Starting Bid Price: </label>
					<input type="number" min="0.01" step="0.01" max="500" value="0.01" name="start_bid_price" required/><br/><br/>                    
                    <input class="db-submit-btn" type="submit" value="Add Auction"/>
                </form>
            </section>
        </section>
    </section>