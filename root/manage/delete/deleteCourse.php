<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require '../../profile/user.php';
    session_start();
    require($INC_DIR . "header.php");
    require($INC_DIR . "top-navbar.php");
    if (!$_SESSION['USER_INFO']->getAdminStatus()) {
        header("Location: ../../profile/profile.php");
    }

    $textbooks = [];
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
		
		$id = mysqli_real_escape_string($link, $_GET['code']);
		$course_query = mysqli_query($link, "SELECT * FROM courses WHERE id=$id");
		$course = mysqli_fetch_array($course_query);
    }
?>
    <section>
        <section class="midbar db-tools-sidebar">
            <br/>
            <a class="return" href="../courseCatalog.php">&lsaquo; Return to Course Catalog</a>
            <h1>Delete a Course</h1>
            <section>
                <form action="../validate/validateCourse.php" method="POST" class="db-form">
                    <input type="hidden" name="db-operator" value="delete"/>
                    <input type="hidden" name="code" value="<?php echo $id ?>"/>
					<table class="db-data">
					<tr>
						<th>id</th>
						<th>Course Code</th>
						<th>Course Description</th>
						<th>Sprint</th>
						<th>Section</th>
						<th>Credits</th>
						<th>Start Time</th>
						<th>End Time</th>
						<th>Days Taught</th>
						<th>Instructor</th>
						<th>Text One: ISBN 10</th>
						<th>Text One: ISBN 13</th>
						<th>Text Two: ISBN 10</th>
						<th>Text Two: ISBN 13</th>
					</tr>
					<?php
					$start_time = date("h:i A", strtotime($course["Start_Time"]));
                    $end_time = date("h:i A", strtotime($course["End_Time"]));
					echo '<tr>
							 <td>'.$course["id"].'</td>
							 <td>'.$course["Course_Code"].'</td>
							 <td>'.$course["Course_Desc"].'</td>
							 <td>'.$course["Sprint"].'</td>
							 <td>'.$course["Section"].'</td>
							 <td>'.$course["Credits"].'</td>
							 <td>'.$start_time.'</td>
							 <td>'.$end_time.'</td>
							 <td>'.$course["Days_Taught"].'</td>
							 <td>'.$course["Instructor"].'</td>
							 <td>'.$course["ISBN_One_v10"].'</td>
							 <td>'.$course["ISBN_One_v13"].'</td>
							 <td>'.$course["ISBN_Two_v10"].'</td>
							 <td>'.$course["ISBN_Two_v13"].'</td>
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