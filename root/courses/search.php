<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    session_start();
    require($INC_DIR . "header.php");
    require($INC_DIR . "top-navbar.php");
    require 'courseSearch.php';
?>
<!--
        <section class="left-aligned">
            
        </section>
-->

        <section class="search-form">
            <br/>
            <a class="return" href="../profile/profile.php">&lsaquo; Return to Profile Page</a>
            <h1>Search for a Course</h1>
            
            <form action="validateSearch.php" method="POST">
<!--                <label for="courseSearch" class="search-label">Choose a Course from the Dropdown Menu: </label><br/>-->
                <select name="course" required>
<!--                    <optgroup>-->
                        <option value="">Please Select a Course</option>
                        <?php
                            if (isset($_SESSION["SEARCH_RESULTS"])) {
                                foreach ($_SESSION["SEARCH_RESULTS"] as $course) {
                                    echo "<option value='{$course["Course_Code"]}'>{$course["Course_Code"]} - {$course["Course_Desc"]}</option>";
                                }
                            }
                        ?>
<!--                    </optgroup>-->
                </select>
                <br/>
                <input class="submit-btn" type="submit" name="submit" value="Search"/>
            </form>
        </section>
<?php require($INC_DIR . "footer.php"); ?>