<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require '../profile/user.php';
    session_start();
    require($INC_DIR . "header.php");
    require($INC_DIR . "top-navbar.php");
    if (!$_SESSION['USER_INFO']->getAdminStatus()) {
        if (!$_SESSION['USER_INFO']->getModStatus()) {
            header("Location: ../profile/profile.php");
        }
    }
?>
<?php
    $auctions = [];
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        
        $auction_query = mysqli_query($link, "SELECT * FROM auctions");
        while ($row = mysqli_fetch_array($auction_query)) {
            array_push($auctions, $row);
        }
    }
?>
    <section>
        <section class="midbar db-tools-sidebar">
            <br/>
            <a class="return" href="../mod/modHome.php">&lsaquo; Return to Mod Home</a>
            <h1>All Auctions</h1>
            <?php
                if (!empty($auctions)) {
//                    echo "hey it worked";
                    echo '<table class="db-data">
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
                             </tr>';
                    foreach($auctions as $auction) {
//                        $start_time = date("h:i A", strtotime($course["Start_Time"]));
//                        $end_time = date("h:i A", strtotime($course["End_Time"]));
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
                    }
                    echo '</table>';
                }
            ?>
            
        </section>        
    </section>

<?php require($INC_DIR . "footer.php"); ?>