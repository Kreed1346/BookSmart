<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require '../profile/user.php';
    session_start();
    require($INC_DIR . "header.php");
    require($INC_DIR . "top-navbar.php");
    if (!$_SESSION['USER_INFO']->getAdminStatus()) {
        header("Location: ../profile/profile.php");
    }
    $textbooks = [];
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
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
            <a class="return" href="../admin/adminHome.php">&lsaquo; Return to Admin Home</a>
            <h1>Textbook Catalog</h1>
            <h2><a class="create-btn" href="add/newTextBook.php">+ Add a Textbook</a></h2>
            <?php
                if (!empty($textbooks)) {
                    echo '<table class="db-data">
                             <tr>
							 	 <th>id</th>
                                 <th>Text Name</th>
                                 <th>Primary Author</th>
                                 <th>Publisher</th>
                                 <th>Year</th>
                                 <th>Edition</th>
                                 <th>ISBN 10</th>
                                 <th>ISBN 13</th>
                                 <th>Edit</th>
                                 <th>Delete?</th>
                             </tr>';
                    foreach($textbooks as $textbook) {
                        echo '<tr>
								 <td>'.$textbook["id"].'</th>
                                 <td>'.$textbook["Text_Name"].'</th>
                                 <td>'.$textbook["Primary_Author"].'</th>
                                 <td>'.$textbook["Publisher"].'</th>
                                 <td>'.$textbook["Year"].'</th>
                                 <td>'.$textbook["Edition"].'</th>
                                 <td>'.$textbook["ISBN_v10"].'</th>
                                 <td>'.$textbook["ISBN_v13"].'</th>
                                 <td><p class="starfruit"><a href="edit/editTextbook.php?code='.$textbook["id"].'">Edit</a></p></td>
                                 <td><p class="starfruit"><a href="delete/deleteTextbook.php?code='.$textbook["id"].'">Delete</a></p></td>
                             </tr>';
                    }
                    echo '</table>';
                }
            ?>            
        </section>        
    </section>
<?php require($INC_DIR . "footer.php"); ?>