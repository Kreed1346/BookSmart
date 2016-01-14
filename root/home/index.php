<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require($INC_DIR. "header.php");
?>
        <nav>
            <a class="login-link" href="../login/login.php"><h4>Login</h4></a>
            <a class="login-link" href="../login/register.php"><h4>Register</h4></a>  
        </nav>
        <section id="welcome" class="custom-box-shadow">
            <h1>Welcome to BookSmart</h1>
            <a class="login-link" href="../login/login.php"><h2>Login</h2></a>
            <a class="login-link" href="../login/register.php"><h2>Register</h2></a>
        </section>
<?php require($INC_DIR. "footer.php"); ?>