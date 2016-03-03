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
            <h1>Delete a User</h1>
            <section>
                <form action="../validate/validateUser.php" method="POST" class="db-form">
                    <input type="hidden" name="db-operator" value="delete"/>
                    <input type="hidden" name="code" value="<?php echo $id ?>"/>
					<table class="db-data">
					<tr>
						<th>id</th>
						<th>Username</th>
						<th>Displayname</th>
						<th>Email</th>
						<th>Moderator</th>
						<th>Administrator</th>
					</tr>
					<?php
					echo '<tr>
							 <td>'.$user["id"].'</td>
							 <td>'.$user["username"].'</td>
							 <td>'.$user["displayname"].'</td>
							 <td>'.$user["email"].'</td>
							 <td>'.(($user["moderator"] > 0) ? "Yes" : "No").'</th>
                             <td>'.(($user["administrator"] > 0) ? "Yes" : "No").'</th>
						 </tr>';	
					?>
					</table>
                    <label>Are you sure you want to delete this entry?</label>
                    <ul class="day-selection">
                        <li><input type="radio" name="choice" value="Yes">Yes</li>
                        <li><input type="radio" name="choice" value="No" checked>No</li>
                    </ul>
					<br/>
                    <input class="db-submit-btn" type="submit" value="Submit Choice"/>
                </form>
            </section>
        </section>
    </section>