<?php 
//    require_once $SWIFT_DIR . 'lib/swift_required.php';
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        //Open connection to db and stay connected until closed
        $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
		
		if (!empty($_POST['db-operator'])) {
			if ($_POST['db-operator'] == "add" || $_POST['db-operator'] == "edit") {
				$uniqueUser = true;
				$sameEmail = true;
				$email = mysqli_real_escape_string($link, filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
				$confirm_email = mysqli_real_escape_string($link, filter_var($_POST['confirm_email'], FILTER_SANITIZE_EMAIL));				
				if (!empty($email) && $email === $confirm_email) {

					$username = mysqli_real_escape_string($link, filter_var($_POST['username'], FILTER_SANITIZE_STRING));
					$displayname = mysqli_real_escape_string($link, filter_var($_POST['displayname'], FILTER_SANITIZE_STRING));
					$mod_privileges = (mysqli_real_escape_string($link, filter_var($_POST['mod_choice'], FILTER_SANITIZE_STRING)) === "Yes") ? 1 : 0;
					$admin_privileges = (mysqli_real_escape_string($link, filter_var($_POST['admin_choice'], FILTER_SANITIZE_STRING)) === "Yes") ? 1 : 0;

					if ($_POST['db-operator'] == "add") {
						$password = mysqli_real_escape_string($link, filter_var($_POST['pass'], FILTER_SANITIZE_STRING)); 
						$confirm_password = mysqli_real_escape_string($link, filter_var($_POST['confirm_pass'], FILTER_SANITIZE_STRING));
						if (!empty($password) && $password === $confirm_password) {
							$user_query = mysqli_query($link, "SELECT * FROM users");
							while($row = mysqli_fetch_array($user_query)) {
								$table_user = $row['username'];
								if($username === $table_user) {						
									$uniqueUser = false;
									header("Location: ../add/newUser.php");
								}
							}

							if($uniqueUser && $sameEmail) {
								$hashPass = password_hash($password, PASSWORD_BCRYPT);
								$result = mysqli_query($link, "INSERT INTO users (username, password, displayname, email, moderator, administrator) VALUES ('$username','$hashPass','$displayname','$confirm_email', $mod_privileges, $admin_privileges)");
								var_dump($result);
								header("Location: ../userCatalog.php");
								session_write_close();
							}
						} else {
							header("Location: ../add/newUser.php");
						}
					} else if ($_POST['db-operator'] == "edit") {
						$user_id = mysqli_real_escape_string($link, filter_var($_POST['id'], FILTER_SANITIZE_STRING));
						$result = mysqli_query($link, "UPDATE users SET username='$username', displayname='$displayname', email='$email', moderator=$mod_privileges, administrator=$admin_privileges WHERE id=$user_id");
						var_dump($result);
						header("Location: ../userCatalog.php");
					}
				} else {
					$sameEmail = false;
					header("Location: ../add/newUser.php");
				}
			} else if ($_POST['db-operator'] == "delete") {
				$choice = mysqli_real_escape_string($link, filter_var($_POST['choice'], FILTER_SANITIZE_STRING));
				if ($choice === "Yes") {
					$user_id =  mysqli_real_escape_string($link, filter_var($_POST['code'], FILTER_SANITIZE_STRING));
					$result = mysqli_query($link, "DELETE FROM users WHERE id=$user_id");
					header("Location: ../userCatalog.php");
				}
			}
		}
		mysqli_close($link);
    }
?>