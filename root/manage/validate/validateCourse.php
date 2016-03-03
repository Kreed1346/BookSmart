<?php
	session_start();
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
		
		if (!empty($_POST['db-operator'])) {
			
			if ($_POST['db-operator'] == "add" || $_POST['db-operator'] == "edit") {
				$course_code = mysqli_real_escape_string($link, filter_var($_POST['course_code'], FILTER_SANITIZE_STRING)); //sanitize courseID input
				$course_desc = mysqli_real_escape_string($link, filter_var($_POST['course_name'], FILTER_SANITIZE_STRING));
				$sprint = mysqli_real_escape_string($link, filter_var($_POST['sprint'], FILTER_SANITIZE_STRING));
				$section = mysqli_real_escape_string($link, filter_var($_POST['section'], FILTER_SANITIZE_STRING));
				$credits = mysqli_real_escape_string($link, filter_var($_POST['credits'], FILTER_SANITIZE_STRING));
				$start_time = date("h:i:s A", strtotime(mysqli_real_escape_string($link, filter_var($_POST['start_time'], FILTER_SANITIZE_STRING)).":00"));
				$end_time = date("h:i:s A", strtotime(mysqli_real_escape_string($link, filter_var($_POST['end_time'], FILTER_SANITIZE_STRING)).":00"));
				
				$monday = (isset($_POST['monday'])) ? mysqli_real_escape_string($link, filter_var($_POST['monday'], FILTER_SANITIZE_STRING)) : null;
				$tuesday = (isset($_POST['tuesday'])) ? mysqli_real_escape_string($link, filter_var($_POST['tuesday'], FILTER_SANITIZE_STRING)) : null;
				$wednesday = (isset($_POST['wednesday'])) ? mysqli_real_escape_string($link, filter_var($_POST['wednesday'], FILTER_SANITIZE_STRING)) : null;
				$thursday = (isset($_POST['thursday'])) ? mysqli_real_escape_string($link, filter_var($_POST['thursday'], FILTER_SANITIZE_STRING)) : null;
				$friday = (isset($_POST['friday'])) ? mysqli_real_escape_string($link, filter_var($_POST['friday'], FILTER_SANITIZE_STRING)) : null;
				
				$days_of_the_week = [
					"monday" => $monday,
					"tuesday" => $tuesday,
					"wednesday" => $wednesday,
					"thursday" => $thursday,
					"friday" => $friday,
				];
				$days_of_week_string = "";
				foreach ($days_of_the_week as $day) {
					if ($day !== null) {
						$days_of_week_string .= $day;
					}
				}
				
				var_dump($start_time);
				var_dump($end_time);

				$instructor = mysqli_real_escape_string($link, filter_var($_POST['instructor'], FILTER_SANITIZE_STRING));

				$text_one =  mysqli_real_escape_string($link, filter_var($_POST['text_one'], FILTER_SANITIZE_STRING));
				$text_two =  mysqli_real_escape_string($link, filter_var($_POST['text_two'], FILTER_SANITIZE_STRING));
				
				
				$isbn_1_10 = $isbn_1_13 = $isbn_2_10 = $isbn_2_13 = "";

				if (!empty($text_one)) {
					$textbook_one_query = mysqli_query($link, "SELECT * FROM textbooks WHERE id='$text_one'");
					while ($row = mysqli_fetch_array($textbook_one_query)) {
						$isbn_1_10 = $row['ISBN_v10'];
						$isbn_1_13 = $row['ISBN_v13'];
					}
				}
				if (!empty($text_two)) {
					$textbook_two_query = mysqli_query($link, "SELECT * FROM textbooks WHERE id='$text_two'");
					while ($row = mysqli_fetch_array($textbook_two_query)) {
						$isbn_2_10 = $row['ISBN_v10'];
						$isbn_2_13 = $row['ISBN_v13'];
					}
					
				}
				
				if ($_POST['db-operator'] === "add") {
					$result = mysqli_query($link, "INSERT INTO courses (Course_Code, Course_Desc, Sprint, Section, Credits, Start_Time, End_Time, Days_Taught, Instructor, ISBN_One_v10, ISBN_One_v13, ISBN_Two_v10, ISBN_Two_v13) VALUES ('$course_code', '$course_desc', $sprint, '$section', $credits, TIME(STR_TO_DATE('$start_time','%h:%i:%s %p')), TIME(STR_TO_DATE('$end_time','%h:%i:%s %p')), '$days_of_week_string', '$instructor', '$isbn_1_10', '$isbn_1_13', '$isbn_2_10', '$isbn_2_13')");
				} else if ($_POST['db-operator'] == "edit") {
					$course_id =  mysqli_real_escape_string($link, filter_var($_POST['id'], FILTER_SANITIZE_STRING));
					$result =mysqli_query($link, "UPDATE courses SET Course_Code='$course_code', Course_Desc='$course_desc', Sprint=$sprint, Section='$section', Credits=$credits, Start_Time=TIME(STR_TO_DATE('$start_time','%h:%i:%s %p')), End_Time=TIME(STR_TO_DATE('$end_time','%h:%i:%s %p')), Days_Taught='$days_of_week_string', Instructor='$instructor', ISBN_One_v10='$isbn_1_10', ISBN_One_v13='$isbn_1_13', ISBN_Two_v10='$isbn_2_10', ISBN_Two_v13='$isbn_2_13' WHERE id=$course_id");
				}
				
			} else if ($_POST['db-operator'] == "delete") {
				$choice = mysqli_real_escape_string($link, filter_var($_POST['choice'], FILTER_SANITIZE_STRING)); //sanitize courseID input
				if ($choice === "Yes") {
					
					$course_id =  mysqli_real_escape_string($link, filter_var($_POST['code'], FILTER_SANITIZE_STRING));
					$result = mysqli_query($link, "DELETE FROM courses WHERE id=$course_id");
				}
			}
		} 
		header("Location: ../courseCatalog.php");
		mysqli_close($link);
    }
?>