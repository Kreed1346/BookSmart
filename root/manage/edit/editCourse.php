<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require '../../profile/user.php';
    session_start();
    require($INC_DIR . "header.php");
    require($INC_DIR . "top-navbar.php");
    if (!$_SESSION['USER_INFO']->getAdminStatus()) {
        header("Location: ../../profile/profile.php");
    }

    $textbooks = [];
	$already_chosen_textbooks = [];
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
		
		$id = mysqli_real_escape_string($link, $_GET['code']);
		$course_info = null;
		$course_query = mysqli_query($link, "SELECT * FROM courses WHERE id=$id");
		$course_info = mysqli_fetch_array($course_query);
		
//		var_dump($course_info);
		
		$first_textbook = $second_textbook = null;
		$first_textbook_query = $second_textbook_query = null;
		
		if (!empty($course_info['ISBN_One_v10']) || !empty($course_info['ISBN_One_v13'])) {
			if (!empty($course_info['ISBN_One_v10'])) {
				$first_textbook_query = mysqli_query($link, "SELECT * FROM textbooks WHERE ISBN_v10='".$course_info['ISBN_One_v10']."'");
			} else {
				$first_textbook_query = mysqli_query($link, "SELECT * FROM textbooks WHERE ISBN_v13='".$course_info['ISBN_One_v13']."'");
			}
			$first_textbook = mysqli_fetch_array($first_textbook_query);
		}
		
		if (!empty($course_info['ISBN_Two_v10']) || !empty($course_info['ISBN_Two_v13'])) {
			if (!empty($course_info['ISBN_One_v10'])) {
				$second_textbook_query = mysqli_query($link, "SELECT * FROM textbooks WHERE ISBN_v10='".$course_info['ISBN_Two_v10']."'");
			} else {
				$second_textbook_query = mysqli_query($link, "SELECT * FROM textbooks WHERE ISBN_v13='".$course_info['ISBN_Two_v13']."'");
			}
			$second_textbook = mysqli_fetch_array($second_textbook_query);
		}
        
        $textbook_query = mysqli_query($link, "SELECT * FROM textbooks");
        while ($row = mysqli_fetch_array($textbook_query)) {
            array_push($textbooks, $row);
        }
    }
?>
    <section>
        <section class="midbar db-tools-sidebar">
            <br/>
            <a class="return" href="../courseCatalog.php">&lsaquo; Return to Course Catalog</a>
            <h1>Edit an Existing Course</h1>
            <section>
                <form action="../validate/validateCourse.php" method="POST" class="db-form">
                    <input type="hidden" name="db-operator" value="edit"/>
					<input type="hidden" name="id" value="<?php echo $id ?>"/>
                    <label for="course_code">Course Code:</label>
                    <input type="text" value="<?php echo $course_info['Course_Code']; ?>" name="course_code" maxlength="6" pattern="[A-Z]{3}\d{3}" placeholder="ABC123" required/>
                    <br/><br/>
                    <label for="course_name">Course Name:</label>
                    <input type="text" value="<?php echo $course_info['Course_Desc']; ?>" name="course_name" placeholder="Enter a course name" required/>
                    <br/><br/>
                    <label for="sprint">Sprint:</label>
                    <select class="right-side-spacing" name="sprint" required>
						<?php
							$sprint_options = [
								"0" => "Quarter Long",
								"1" => "Sprint 1",
								"2" => "Sprint 2"
							];
							foreach($sprint_options as $option => $key) {
								echo '<option value="'.$option.'"';
								if ($option == $course_info["Sprint"]) {
									echo ' selected';
								}
								echo '>'.$key.'</option>';
							}
						?>
                    </select>
                    <label name="section">Section:</label>
                    <select name="section" required>
						<?php
							$section_options = [
								"-" => "None",
								"A" => "A",
								"B" => "B",
								"C" => "C",
								"D" => "D",
								"E" => "E",
								"F" => "F"
							];
							foreach ($section_options as $option => $key) {
								echo '<option value="'.$option.'"';
								if ($option == $course_info["Section"]) {
									echo ' selected';
								}
								echo '>'.$key.'</option>';
							}
						?>
                    </select>
                    <br/><br/>
                    <label>Credits:</label>
                    <input class="right-side-spacing" type="number" value="<?php echo $course_info['Credits']; ?>" name="credits" min="2" max="6" value="2"/>
					<?php
						$days = str_split($course_info['Days_Taught']);
//						var_dump($days);
					?>
                    <label>Days of the Week:</label>
                    <ul class="day-selection">
                        <li><input type="checkbox" name="monday" value="M" <?php echo (in_array("M", $days) ? " checked":""); ?> >Monday</li>
                        <li><input type="checkbox" name="tuesday" value="T" <?php echo (in_array("T", $days) ? " checked":""); ?> >Tuesday</li>
                        <li><input type="checkbox" name="wednesday" value="W" <?php echo (in_array("W", $days) ? " checked":""); ?> >Wednesday</li>
                        <li><input type="checkbox" name="thursday" value="H" <?php echo (in_array("H", $days) ? " checked":""); ?> >Thursday</li>
                        <li><input type="checkbox" name="friday" value="F" <?php echo (in_array("F", $days) ? " checked":""); ?> >Friday</li>
                    </ul>
                    <br/><br/>
                    <label>Course Start Time</label>
                    <input class="right-side-spacing" type="time" name="start_time" value="<?php echo date("h:i:s", strtotime($course_info['Start_Time'])); ?>"/>
                    <label>Course End Time</label>
                    <input type="time" name="end_time" value="<?php echo date("h:i:s", strtotime($course_info['End_Time'])); ?>"/>
                    <br/><br/>
                    <label for="instructor">Course Instructor</label>
                    <input type="text" name="instructor" placeholder="Name of course instructor" value="<?php echo $course_info['Instructor']; ?>"/>
                    <br/><br/>
                    <label>Required Textbooks</label>
                    <section class="book-selection">
                        <aside>
                            <label for="text_one">First Textbook</label>
                            <select name="text_one">
                                <option value="">Please Choose a Textbook</option>
                                <?php
                                    foreach ($textbooks as $book) {
                                        $id = $book['id'];
                                        $value = $book["Text_Name"];
										echo "<option value='$id'";
										if ($first_textbook !== null && $id == $first_textbook['id']) {
											echo " selected";
										}
                                        echo ">$value</option>";
                                    }
                                ?>
                            </select>
                        </aside>
                        <aside>
                            <label for="text_two">Second Textbook</label>
                            <select name="text_two">
                                <option value="">Please Choose a Textbook</option>
                                <?php
                                    foreach ($textbooks as $book) {
                                        $id = $book['id'];
                                        $value = $book["Text_Name"];
                                        echo "<option value='$id'";
										if ($second_textbook !== null && $id == $second_textbook['id']) {
											echo " selected";
										}
                                        echo ">$value</option>";
                                    }
                                ?>
                            </select>
                        </aside>
                    </section>
                    <input class="db-submit-btn" type="submit" value="Apply Changes"/>
                </form>
            </section>
        </section>
    </section>