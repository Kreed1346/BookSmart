<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
require_once($INC_DIR. "header.php");
?>
    <section id="home" class="custom-box-shadow">
        
        <nav class="profile-header index-header custom-box-shadow">
            <?php
                echo '<a class="login-link login-btn" href="../login/login.php"><p>Already a member? Login here.<p></a>';
            ?>
        </nav>
        <section id="welcome" class="inset-box-shadow">
            <section>
                <h1>Welcome to</h1>
                <h1 class="logo"><img src="../assets/images/booksmart-logo-small.png">ookSmart</h1>
                <h1>Where buying textbooks just got easier.</h1>
            </section>
            
<!--            <a class="login-link" href="../login/login.php"><h2>Login</h2></a>-->
            <h2 class="login-link">New to BookSmart?</h2>
            <a class="login-link" href="../login/register.php"><h2 class="register-button">Register Here</h2></a>
        </section>
    </section>
<?php require($INC_DIR. "footer.php"); ?>
