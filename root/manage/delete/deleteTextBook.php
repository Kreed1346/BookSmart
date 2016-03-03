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
		$textbook_query = mysqli_query($link, "SELECT * FROM textbooks WHERE id=$id");
		$textbook = mysqli_fetch_array($textbook_query);
    }
?>
    <section>
        <section class="midbar db-tools-sidebar">
            <br/>
            <a class="return" href="../textbookCatalog.php">&lsaquo; Return to Course Catalog</a>
            <h1>Delete a Course</h1>
            <section>
                <form action="../validate/validateTextbook.php" method="POST" class="db-form">
                    <input type="hidden" name="db-operator" value="delete"/>
                    <input type="hidden" name="code" value="<?php echo $id ?>"/>
					<table class="db-data">
					<tr>
						<th>id</th>
						<th>Text Name</th>
						<th>Primary Author</th>
						<th>Publisher</th>
						<th>Year</th>
						<th>Edition</th>
						<th>ISBN_v10</th>
						<th>ISBN_v13</th>
					</tr>
					<?php
					echo '<tr>
							 <td>'.$textbook["id"].'</td>
							 <td>'.$textbook["Text_Name"].'</td>
							 <td>'.$textbook["Primary_Author"].'</td>
							 <td>'.$textbook["Publisher"].'</td>
							 <td>'.$textbook["Year"].'</td>
							 <td>'.$textbook["Edition"].'</td>
							 <td>'.$textbook["ISBN_v10"].'</td>
							 <td>'.$textbook["ISBN_v13"].'</td>
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