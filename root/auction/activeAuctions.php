<?php

        $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }

        $updateNeeded = true;
        
        if (isset($_SESSION['ACTIVE_AUCTIONS'])) {
            $auction_query = mysqli_query($link, "SELECT * FROM auctions WHERE auction_ended=0");
            $updated_active = [];
            while($row = mysqli_fetch_array($auction_query)) {
                if (!in_array($row, $updated_active)) {
                    array_push($updated_active, $row);
                }
            }
            if (count($_SESSION['ACTIVE_AUCTIONS']) !== count($updated_active)) {
                $_SESSION['ACTIVE_AUCTIONS'] = $updated_active;
            } else {
                $updatedNeeded = false;
            }
        } else if ($updateNeeded){
            $auction_query = mysqli_query($link, "SELECT * FROM auctions WHERE auction_ended=0");
            
            $active_auctions = [];
            while($row = mysqli_fetch_array($auction_query)) {
                if (!in_array($row, $active_auctions)) {
                    array_push($active_auctions, $row);
                }
            }
            $_SESSION['ACTIVE_AUCTIONS'] = $active_auctions;
        }
        

?>