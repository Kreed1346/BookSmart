<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
require($INC_DIR. "header.php"); ?>
        <h1>Login</h1>
        <form>
            <label for="username">Username</label>
            <input type="text" name="username" placeholder="Enter username here."/>
            <br/>
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Enter password here."/>
            <br/>
            <input type="submit" name="submit" value="Submit"/>
        </form>
<?php require($INC_DIR. "footer.php"); ?>