<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require '../../profile/user.php';
    session_start();
    require($INC_DIR . "header.php");
    require($INC_DIR . "top-navbar.php");
    if (!$_SESSION['USER_INFO']->getAdminStatus()) {
        header("Location: ../../profile/profile.php");
    }

	if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
		
		$id = mysqli_real_escape_string($link, $_GET['code']);
		$user_query = mysqli_query($link, "SELECT * FROM users WHERE id=$id");
		$user = mysqli_fetch_array($user_query);
    }

?>
    <section>
        <section class="midbar db-tools-sidebar">
            <br/>
            <a class="return" href="../userCatalog.php">&lsaquo; Return to Course Catalog</a>
            <h1>Create a User</h1>
            <section>
                <form action="../validate/validateUser.php" method="POST" class="db-form">
                    <input type="hidden" name="db-operator" value="edit"/>
					<input type="hidden" name="id" value="<?php echo $id; ?>" />
                    <label for="username">Username:</label>
                    <input class="right-side-spacing" type="text" name="username" placeholder="Enter a username" value="<?php echo $user['username']?>" required/>
                    <label for="displayname">Displayname:</label>
                    <input type="text" name="displayname" placeholder="Enter a displayname" value="<?php echo $user['displayname']?>" required/>
                    <br/><br/>
					<label for="isbn_v10">Email: </label>
					<input class="right-side-spacing" type="text" name="email" placeholder="Enter an email" value="<?php echo $user['email']?>" required/>
					<label for="isbn_v13">Confirm Email:</label>
					<input type="text" name="confirm_email" placeholder="Please confirm the email" value="<?php echo $user['email']?>" required/>
                    <br/><br/>
					<label>Moderator Access Allowed</label>
                    <ul class="day-selection right-side-spacing">
						<?php
							if ($user['moderator']) {
								echo '<li><input type="radio" name="mod_choice" value="Yes" checked>Yes</li>';
                        		echo '<li><input type="radio" name="mod_choice" value="No">No</li>';
							} else {
								echo '<li><input type="radio" name="mod_choice" value="Yes">Yes</li>';
                        		echo '<li><input type="radio" name="mod_choice" value="No" checked>No</li>';
							}
						?>
                    </ul>
					<label>Administrative Access Allowed</label>
                    <ul class="day-selection">
						<?php
							if ($user['moderator']) {
								echo '<li><input type="radio" name="admin_choice" value="Yes" checked>Yes</li>';
                        		echo '<li><input type="radio" name="admin_choice" value="No">No</li>';
							} else {
								echo '<li><input type="radio" name="admin_choice" value="Yes">Yes</li>';
                        		echo '<li><input type="radio" name="admin_choice" value="No" checked>No</li>';
							}
						?>
                    </ul>
					<br/><br/>
                    <input class="db-submit-btn" type="submit" value="Update User"/>
                </form>
            </section>
        </section>
    </section>