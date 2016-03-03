<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require '../../profile/user.php';
    session_start();
    require($INC_DIR . "header.php");
    require($INC_DIR . "top-navbar.php");
    if (!$_SESSION['USER_INFO']->getAdminStatus()) {
        header("Location: ../../profile/profile.php");
    }

?>
    <section>
        <section class="midbar db-tools-sidebar">
            <br/>
            <a class="return" href="../userCatalog.php">&lsaquo; Return to Course Catalog</a>
            <h1>Create a User</h1>
            <section>
                <form action="../validate/validateUser.php" method="POST" class="db-form">
                    <input type="hidden" name="db-operator" value="add"/>
                    <label for="username">Username:</label>
                    <input class="right-side-spacing" type="text" name="username" placeholder="Enter a username" required/>
                    <label for="displayname">Displayname:</label>
                    <input type="text" name="displayname" placeholder="Enter a displayname" required/>
                    <br/><br/>
					<label for="publisher">Password:</label>
                    <input class="right-side-spacing" type="password" name="pass" placeholder="Enter a password" required/>
                    <label for="year">Confirm Password:</label>					
                    <input type="password" name="confirm_pass" placeholder="Please confirm the password" required/>
                    <br/><br/>
					<label for="isbn_v10">Email: </label>
					<input class="right-side-spacing" type="text" name="email" placeholder="Enter an email" required/>
					<label for="isbn_v13">Confirm Email:</label>
					<input type="text" name="confirm_email" placeholder="Please confirm the email" required/>
                    <br/><br/>
					<label>Moderator Access Allowed</label>
                    <ul class="day-selection right-side-spacing">
                        <li><input type="radio" name="mod_choice" value="Yes">Yes</li>
                        <li><input type="radio" name="mod_choice" value="No" checked>No</li>
                    </ul>
					<label>Administrative Access Allowed</label>
                    <ul class="day-selection">
                        <li><input type="radio" name="admin_choice" value="Yes">Yes</li>
                        <li><input type="radio" name="admin_choice" value="No" checked>No</li>
                    </ul>
					<br/><br/>
                    <input class="db-submit-btn" type="submit" value="Add User"/>
                </form>
            </section>
        </section>
    </section>