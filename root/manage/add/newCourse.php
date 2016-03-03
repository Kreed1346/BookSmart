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
            <h1>Create a Course</h1>
            <section>
                <form action="../validate/validateCourse.php" method="POST" class="db-form">
                    <input type="hidden" name="db-operator" value="add"/>
                    <label for="course_code">Course Code:</label>
                    <input type="text" name="course_code" maxlength="6" pattern="[A-Z]{3}\d{3}" placeholder="ABC123" required/>
                    <br/><br/>
                    <label for="course_name">Course Name:</label>
                    <input type="text" name="course_name" placeholder="Enter a course name" required/>
                    <br/><br/>
                    <label for="sprint">Sprint:</label>
                    <select class="right-side-spacing" name="sprint" required>
                        <option value="0">Quarter Long</option>
                        <option value="1">Sprint 1</option>
                        <option value="2">Sprint 2</option>
                    </select>
                    <label name="section">Section:</label>
                    <select name="section" required>
                        <option>None</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                    </select>
                    <br/><br/>
                    <label>Credits:</label>
                    <input class="right-side-spacing" type="number" name="credits" min="2" max="6" value="2"/>
                    <label>Days of the Week:</label>
                    <ul class="day-selection">
                        <li><input type="checkbox" name="monday" value="M">Monday</li>
                        <li><input type="checkbox" name="tuesday" value="T">Tuesday</li>
                        <li><input type="checkbox" name="wednesday" value="W">Wednesday</li>
                        <li><input type="checkbox" name="thursday" value="H">Thursday</li>
                        <li><input type="checkbox" name="friday" value="F">Friday</li>
                    </ul>
                    <br/><br/>
                    <label>Course Start Time</label>
                    <input class="right-side-spacing" type="time" name="start_time"/>
                    <label>Course End Time</label>
                    <input type="time" name="end_time"/>
                    <br/><br/>
                    <label for="instructor">Course Instructor</label>
                    <input type="text" name="instructor" placeholder="Name of course instructor"/>
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
                                        echo "<option value='$id'>$value</option>";
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
                                        echo "<option value='$id'>$value</option>";
                                    }
                                ?>
                            </select>
                        </aside>
                    </section>
                    <input class="db-submit-btn" type="submit" value="Add Course"/>
                </form>
            </section>
        </section>
    </section>