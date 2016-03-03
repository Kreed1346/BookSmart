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
				$text_name = mysqli_real_escape_string($link, filter_var($_POST['text_name'], FILTER_SANITIZE_STRING));
				$primary_author = mysqli_real_escape_string($link, filter_var($_POST['primary_author'], FILTER_SANITIZE_STRING));
				$publisher = mysqli_real_escape_string($link, filter_var($_POST['publisher'], FILTER_SANITIZE_STRING));
				$year = mysqli_real_escape_string($link, filter_var($_POST['year'], FILTER_SANITIZE_STRING));
				$edition = mysqli_real_escape_string($link, filter_var($_POST['edition'], FILTER_SANITIZE_STRING));
				$isbn_v10 =  "ISBN-10:".mysqli_real_escape_string($link, filter_var($_POST['isbn_v10'], FILTER_SANITIZE_STRING));
				$isbn_v13 =  "ISBN-13:".mysqli_real_escape_string($link, filter_var($_POST['isbn_v13'], FILTER_SANITIZE_STRING));
				
				if ($_POST['db-operator'] === "add") {
					$result = mysqli_query($link, "INSERT INTO textbooks (Text_Name, Primary_Author, Publisher, Year, Edition, ISBN_v10, ISBN_v13) VALUES ('$text_name', '$primary_author', '$publisher', '$year', '$edition', '$isbn_v10', '$isbn_v13')");
				} else if ($_POST['db-operator'] == "edit") {
					$text_id =  mysqli_real_escape_string($link, filter_var($_POST['id'], FILTER_SANITIZE_STRING));
					$result = mysqli_query($link, "UPDATE textbooks SET Text_Name='$text_name', Primary_Author='$primary_author', Publisher='$publisher', Year='$year', Edition='$edition', ISBN_v10='$isbn_v10', ISBN_v13='$isbn_v13' WHERE id=$text_id");
				}
				
			} else if ($_POST['db-operator'] == "delete") {
				$choice = mysqli_real_escape_string($link, filter_var($_POST['choice'], FILTER_SANITIZE_STRING));
				if ($choice === "Yes") {
					
					$text_id =  mysqli_real_escape_string($link, filter_var($_POST['code'], FILTER_SANITIZE_STRING));
					$result = mysqli_query($link, "DELETE FROM textbooks WHERE id=$text_id");
				}
			}
		} 
		header("Location: ../textbookCatalog.php");
		mysqli_close($link);
    }
?>