<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    session_start();
    require($INC_DIR . "header.php");
    require($INC_DIR . "top-navbar.php");
    require 'courseSearch.php';
?>
        <section class="search-form">
            <br/>
            <a class="return" href="../profile/profile.php">&#10094; Return to Profile Page</a>
            <h1>Search for a Course</h1>
            
            <form action="validateSearch.php" method="POST">
                <label for="courseSearch" class="search-label">Chooose a Course from the dropdown menu: </label><br/>
                <select name="course" required>
                    <option value="">Please choose on option below</option>
                    <?php
                        if (isset($_SESSION["SEARCH_RESULTS"])) {
                            foreach ($_SESSION["SEARCH_RESULTS"] as $course) {
                                echo "<option value='{$course["Course_Code"]}'>{$course["Course_Code"]} - {$course["Course_Desc"]}</option>";
                            }
                        }
                    ?>
                </select>
<!--
                <input type="text" name="courseID" placeholder="Enter your course ID"/>
                <br/>
                <label for="courseName" class="search-label">Course Name: </label>
                <input type="text" name="courseName" placeholder="Enter course name"/>
-->
                <br/>
                <input class="submit-btn" type="submit" name="submit" value="Search"/>
            </form>
        </section>
<!--        <section id="search-results">-->
            <?php 
//                if (isset($_SESSION["SEARCH_RESULTS"])) {
//                    if (!empty($_SESSION["SEARCH_RESULTS"])) {
//                        $count = count($_SESSION["SEARCH_RESULTS"]);
//                        $string = $count . ($count . ($count > 1) ? " results" : " result") . " found.";
//                        echo "<p>" . $string . "</p>";
//                        foreach($_SESSION["SEARCH_RESULTS"] as $searchResult) {
//                            echo "<a href='courseInfo.php?courseID=$searchResult[0]'><p class='search-result'>$searchResult[0] - $searchResult[1]</p></a>";
//                        }
//                    } else {
//                        echo "<p>No courses found matching the search parameters.</p>";
//                    }
//                } else {
//                    echo "<p>A search has not been ran yet.</p>";
//                }
//                
            ?>
<!--        </section>-->

<?php require($INC_DIR . "footer.php"); ?>