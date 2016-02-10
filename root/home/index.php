<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    
?>
    <section id="home">
        <?php require_once($INC_DIR. "header.php"); ?>
        <nav class="profile-header index-header custom-box-shadow">
            <?php
                echo '<a class="login-link" href="../login/login.php">Login</a>';
                echo '<a class="login-link" href="../login/register.php">Register</a>';
            ?>
        </nav>
        <section id="welcome" class="custom-box-shadow">
            <h1>Welcome to</h1>
            <h1 class="logo"><img src="../assets/images/booksmart-logo-small.png">ookSmart</h1>
            <a class="login-link" href="../login/login.php"><h2>Login</h2></a>
            <a class="login-link" href="../login/register.php"><h2>Register</h2></a>
        </section>
        <?php require($INC_DIR. "footer.php"); ?>
    </section>
