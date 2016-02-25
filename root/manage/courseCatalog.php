<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require '../profile/user.php';
    session_start();
    require($INC_DIR . "header.php");
    require($INC_DIR . "top-navbar.php");
    if (!$_SESSION['USER_INFO']->getAdminStatus()) {
        header("Location: ../profile/profile.php");
    }
?>
<?php
    $courses = [];
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        
        $course_query = mysqli_query($link, "SELECT * FROM courses");
        while ($row = mysqli_fetch_array($course_query)) {
            array_push($courses, $row);
        }
    }
?>
    <section>
        <section class="midbar db-tools-sidebar">
            <br/>
            <a class="return" href="../admin/adminHome.php">&lsaquo; Return to Admin Home</a>
            <h1>Course Catalog</h1>
            <?php
                if (!empty($courses)) {
//                    echo "hey it worked";
                    echo '<table class="db-data">
                             <tr>
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
                             </tr>';
                    foreach($courses as $course) {
                        $start_time = date("h:i A", strtotime($course["Start_Time"]));
                        $end_time = date("h:i A", strtotime($course["End_Time"]));
                        echo '<tr>
                                 <td>'.$course["Course_Code"].'</th>
                                 <td>'.$course["Course_Desc"].'</th>
                                 <td>'.$course["Sprint"].'</th>
                                 <td>'.$course["Section"].'</th>
                                 <td>'.$course["Credits"].'</th>
                                 <td>'.$start_time.'</th>
                                 <td>'.$end_time.'</th>
                                 <td>'.$course["Days_Taught"].'</th>
                                 <td>'.$course["Instructor"].'</th>
                                 <td>'.$course["ISBN_One_v10"].'</th>
                                 <td>'.$course["ISBN_One_v13"].'</th>
                                 <td>'.$course["ISBN_Two_v10"].'</th>
                                 <td>'.$course["ISBN_Two_v13"].'</th>
                             </tr>';
                    }
                    echo '</table>';
                }
            ?>
            
        </section>        
    </section>

<?php require($INC_DIR . "footer.php"); ?>