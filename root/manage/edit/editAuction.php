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
		
		$id = mysqli_real_escape_string($link, $_GET['code']);
		$auction_query = mysqli_query($link, "SELECT * FROM auctions WHERE auction_id=$id");
		$auction = mysqli_fetch_array($auction_query);
		
		$textbook_query_string = "";
		if (strlen($auction['isbn']) == 10) {
			$auction['isbn'] = 'ISBN-10:'.$auction['isbn'];
			$textbook_query_string = "SELECT * FROM textbooks WHERE ISBN_v10='".$auction['isbn']."'";
		} else if (strlen($auction['isbn']) == 13) {
			$auction['isbn'] = 'ISBN-13:'.$auction['isbn'];
			$textbook_query_string = "SELECT * FROM textbooks WHERE ISBN_v13='".$auction['isbn']."'";
		}
//		var_dump($auction['isbn']);
		
		$chosen_book_query = mysqli_query($link, $textbook_query_string);
		$chosen_book = mysqli_fetch_array($chosen_book_query);
    }
?>
    <section>
        <section class="midbar db-tools-sidebar">
            <br/>
            <a class="return" href="../auctions.php">&lsaquo; Return to Auction Catalog</a>
            <h1>Edit an Auction</h1>
            <section>
                <form action="../validate/validateAuction.php" method="POST" class="db-form">
                    <input type="hidden" name="db-operator" value="edit"/>
					<input type="hidden" name="auctioneer_id" value="<?php echo $auction['user_id']; ?>" />
					<input type="hidden" name="id" value="<?php echo $id; ?>" />
                    <label for="title">Title:</label>
                    <input type="text" name="title" placeholder="Enter a title" value="<?php echo $auction['auction_title']?>" required/>
                    <br/><br/>
                    <label for="description">Description:</label>
                    <input type="text" name="description" placeholder="Enter a description" value="<?php echo $auction['auction_desc']?>" required/>
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
										if ($id === $chosen_book['id']) {
											echo "<option value='$id' selected>$value</option>";
										} else {
                                        	echo "<option value='$id'>$value</option>";
										}
                                    }
                                ?>
                            </select>
                        </aside>
                    </section>
					<label for="bin_price">Buy-It-Now Price: </label>
					<input type="number" min="0.01" step="0.01" max="500" value="<?php echo $auction['bin_price']?>" name="bin_price" required/><br/><br/>
					<label for="start_bid_price">Starting Bid Price: </label>
					<input type="number" min="0.01" step="0.01" max="500" value="<?php echo $auction['start_bid_price']?>" name="start_bid_price" required/><br/><br/>                    
                    <input class="db-submit-btn" type="submit" value="Apply Changes"/>
                </form>
            </section>
        </section>
    </section>