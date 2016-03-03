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

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
		
		$id = mysqli_real_escape_string($link, $_GET['code']);
		$auction_query = mysqli_query($link, "SELECT * FROM auctions WHERE auction_id=$id");
		$auction = mysqli_fetch_array($auction_query);
    }
?>
    <section>
        <section class="midbar db-tools-sidebar">
            <br/>
            <a class="return" href="../auctions.php">&lsaquo; Return to Auction Catalog</a>
            <h1>Delete an Auction</h1>
            <section>
                <form action="../validate/validateAuction.php" method="POST" class="db-form">
                    <input type="hidden" name="db-operator" value="delete"/>
                    <input type="hidden" name="code" value="<?php echo $id ?>"/>
					<table class="db-data">
					<tr>
						<th>Id</th>
						<th>Title</th>
						<th>Description</th>
						<th>Text Name</th>
						<th>ISBN</th>
						<th>Auctioneer Id</th>
						<th>Buy-It-Now Price</th>
						<th>Starting Bid Price</th>
						<th>Creation Timestamp</th>
						<th>End Timestamp</th>
						<th>Auction Ended?</th>
						<th>Winner Username</th>
					</tr>
					<?php
					echo '<tr>
							 <td>'.$auction["auction_id"].'</th>
							 <td>'.$auction["auction_title"].'</th>
							 <td>'.$auction["auction_desc"].'</th>
							 <td>'.$auction["text_name"].'</th>
							 <td>'.$auction["isbn"].'</th>
							 <td>'.$auction["user_id"].'</th>
							 <td>'.$auction["bin_price"].'</th>
							 <td>'.$auction["start_bid_price"].'</th>
							 <td>'.$auction["auction_creation_time"].'</th>
							 <td>'.$auction["auction_end_time"].'</th>
							 <td>'.(($auction["auction_ended"] > 0) ? "Yes" : "No").'</th>
							 <td>'.$auction["winner_username"].'</th>
						 </tr>';	
					?>
					</table>
                    <label>Are you sure you want to delete this entry?</label>
                    <ul class="day-selection">
                        <li><input type="radio" name="choice" value="Yes">Yes</li>
                        <li><input type="radio" name="choice" value="No" checked>No</li>
                    </ul>
					<br/>
                    <input class="db-submit-btn" type="submit" value="Submit Choice"/>
                </form>
            </section>
        </section>
    </section>