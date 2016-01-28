<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require($INC_DIR . "header.php");
    session_start();
?>
        <nav class="profile-header">
            <a class="return" href="billing-information.php">&#10094; Return to Billing Information Page</a>
        <?php
            if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"]) {
                echo '<h1><a class="profile-name-link" href="../profile/profile.php">' . $_SESSION["displayname"] . '</a></h1>';
                echo '<a class="logout" href="../profile/logout.php">Not ' . $_SESSION["displayname"] . '? Logout.</a>';
            } else {
                Print '<script>window.location.assign("../login/login.php");</script>';
            }
        ?>
        </nav>
        <section class="cc-content">
            <h1>Add a Card</h1>
            <form action="addCard.php" method="POST">
                <label for="cardtype">Card Company</label>
                <section>
                    <label>
                        <input type="radio" name="cardtype" value="visa" checked/>
                        <img src="../assets/images/visa-icon.png">
                    </label>
                    <label>
                        <input type="radio" name="cardtype" value="mastercard"/>
                        <img src="../assets/images/mastercard-icon.png">
                    </label>
                    <label>
                        <input type="radio" name="cardtype" value="discover"/>
                        <img src="../assets/images/discover-icon.png">
                    </label>
                    <label>
                        <input type="radio" name="cardtype" value="amex"/>
                        <img src="../assets/images/amex-icon.png">
                    </label>
                </section>
                <label for="cardnumber">Card Number</label>
                <input class="credit-card" type="text" name="cardnumber" pattern="[0-9]{13,16}" required>
                <label for="cvv">CVV</label>
                <input class="cvv" type="text" name="cvv" pattern="[0-9]{3}" required><br>
                <label for="expirationmonth">Expiry Date</label>
                <input type="month" name="expirationmonth" value="" required><br>
                <label for="firstname">First Name</label>
                <input type="text" name="firstname" required><br>
                <label for="lastname">Last Name</label>
                <input type="text" name="lastname" required><br>
                <input class="submit-btn" type="submit" name="submit" value="Submit">
            </form>
        </section>
<?php
        if($_SERVER["REQUEST_METHOD"] == "POST") {
//            $sdkConfig = array (
//                "mode" => "sandbox"
//            );
//            
            $cred = new \PayPal\Auth\OAuthTokenCredential(
                "ATbkEXn3uQcX-oP8U9qjvzMrx6fjKB5aRP2nei--_YM0UX8Nq4i6dkdOjn0iw_rPRXnvDJbprf446wlz",
                "EGMD_Y19KOKXTabyKlHwU1JnNNzUdD8qK_Gv3r1hvHhP33w1CXWkRoukGgViQB9iBHKu0LB6VQL37YUF"
            );
            
            $apiContext = new \PayPal\Rest\ApiContext($cred, 'Request ' . time());
            
            $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }
            
            $cardtype = mysqli_real_escape_string($link, $_POST['cardtype']);
            $cardnumber = mysqli_real_escape_string($link, $_POST['cardnumber']);
            $cvv = mysqli_real_escape_string($link, $_POST['cvv']);
            $monthValueParts = explode('-', mysqli_real_escape_string($link, $_POST['expirationmonth']));
            $expiryYear = $monthValueParts[0];
            $expiryMonth = $monthValueParts[1];
            $firstname = mysqli_real_escape_string($link, $_POST['firstname']);
            $lastname = mysqli_real_escape_string($link, $_POST['lastname']);

            $creditcard = new \PayPal\Api\CreditCard();
            $creditcard->setType($cardtype);
            $creditcard->setNumber($cardnumber);
            $creditcard->setExpire_month($expiryMonth);
            $creditcard->setExpire_year($expiryYear);
            $creditcard->setCvv2($cvv);
            $creditcard->setFirst_name($firstname);
            $creditcard->setLast_name($lastname);
            
            
            try {
                $creditcard->create($apiContext); //error happens here
//                echo $creditcard;
                $_SESSION['CARD_CREATED'] = true; //allows for dynamic display of card creation later
                header('Location: billing-information.php');
            } catch (\PPConnectionException $ex) {
                echo '<p class="error-catch">Exception thrown!</p>';
                echo '<p class="error-catch">'.$ex.'</p>';
            } finally {
                mysqli_close($link);
            }
            
            //Something's not working with the way the Credit Card is being sent out
        }
?>
<?php require($INC_DIR . "footer.php"); ?>