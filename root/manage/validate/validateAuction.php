<?php 
//    require_once $SWIFT_DIR . 'lib/swift_required.php';
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        //Open connection to db and stay connected until closed
        $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
		
		if (!empty($_POST['db-operator'])) {
			if ($_POST['db-operator'] == "add" || $_POST['db-operator'] == "edit") {
				$title = mysqli_real_escape_string($link, filter_var($_POST['title'], FILTER_SANITIZE_STRING));
				$description = mysqli_real_escape_string($link, filter_var($_POST['description'], FILTER_SANITIZE_STRING));
				$textbook_id = mysqli_real_escape_string($link, filter_var($_POST['textbook'], FILTER_SANITIZE_STRING));
				$auctioneer_id = mysqli_real_escape_string($link, filter_var($_POST['auctioneer_id'], FILTER_SANITIZE_STRING));
				$bin_price = mysqli_real_escape_string($link, filter_var($_POST['bin_price'], FILTER_SANITIZE_STRING));
				$start_bid_price = mysqli_real_escape_string($link, filter_var($_POST['start_bid_price'], FILTER_SANITIZE_STRING));
				
				$textbook_query = mysqli_query($link, "SELECT * FROM textbooks WHERE id=$textbook_id");
				$textbook = mysqli_fetch_array($textbook_query);
				$textbook_name = $textbook['Text_Name'];
				$isbn = "";
				if (!empty($textbook['ISBN_v10'])) {
					$isbn = substr($textbook["ISBN_v10"], 8, 10);
				} else if (!empty($textbook['ISBN_v13'])) {
					$isbn = substr($textbook["ISBN_v13"], 8, 13);
				}
				var_dump($isbn);
						   
				if ($_POST['db-operator'] == "add") {
					$creation_time = date('Y-m-d H:i:s', strtotime("now"));
    				$end_time = date('Y-m-d H:i:s', strtotime("+1 week"));
					$result = mysqli_query($link, "INSERT INTO auctions (auction_title, auction_desc, text_name, isbn, user_id, bin_price, start_bid_price, auction_creation_time, auction_end_time, auction_ended, winner_username) VALUES ('$title', '$description', '$textbook_name', '$isbn', '$auctioneer_id', '$bin_price', '$start_bid_price', '$creation_time', '$end_time', '0', NULL) ");
					var_dump($result);
				} else if ($_POST['db-operator'] == "edit") {
					$auction_id = mysqli_real_escape_string($link, filter_var($_POST['id'], FILTER_SANITIZE_STRING));
					$result = mysqli_query($link, "UPDATE auctions SET auction_title='$title', auction_desc='$description', text_name='$textbook_name', isbn=$isbn, bin_price=$bin_price, start_bid_price=$start_bid_price WHERE auction_id=$auction_id");
					var_dump($result);
					header("Location: ../auctions.php");
				}
				header("Location: ../auctions.php");
			} else if ($_POST['db-operator'] == "delete") {
				$choice = mysqli_real_escape_string($link, filter_var($_POST['choice'], FILTER_SANITIZE_STRING));
				if ($choice === "Yes") {
					$auction_id =  mysqli_real_escape_string($link, filter_var($_POST['code'], FILTER_SANITIZE_STRING));
					$result = mysqli_query($link, "DELETE FROM auctions WHERE auction_id='$auction_id'");
					header("Location: ../auctions.php");
				}
			}
		}
		mysqli_close($link);
    }
?>