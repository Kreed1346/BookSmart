<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require($INC_DIR . "header.php");
    session_start();
?>
        <nav class="profile-header">
            <a class="return" href="../profile/profile.php">&#10094; Return to Profile Page</a>
        <?php
            if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"]) {
                echo '<h1><a class="profile-name-link" href="../profile/profile.php">' . $_SESSION["displayname"] . '</a></h1>';
                echo '<a class="logout" href="logout.php">Not ' . $_SESSION["displayname"] . '? Logout.</a>';
            } else {
                Print '<script>window.location.assign("../login/login.php");</script>';
            }
        ?>
        </nav>
        <section class="search-form">
            <h1>Search for a Course</h1>
            
            <form action="validateSearch.php" method="POST">
                <label for="courseID" class="search-label">Course ID: </label>
                <input type="text" name="courseID" placeholder="Enter your course ID"/>
                <br/>
                <label for="courseName" class="search-label">Course Name: </label>
                <input type="text" name="courseName" placeholder="Enter course name"/>
                <br/>
                <input class="submit-btn" type="submit" name="submit" value="Search"/>
            </form>
        </section>
        <section id="search-results">
            <?php 
                if (isset($_SESSION["SEARCH_RESULTS"])) {
                    if (!empty($_SESSION["SEARCH_RESULTS"])) {
                        $count = count($_SESSION["SEARCH_RESULTS"]);
                        $string = $count . ($count . ($count > 1) ? " results" : " result") . " found.";
                        echo "<p>" . $string . "</p>";
                        foreach($_SESSION["SEARCH_RESULTS"] as $searchResult) {
                            echo "<a href='course-info.php?courseID=$searchResult[0]'><p class='search-result'>$searchResult[0] - $searchResult[1]</p></a>";
                        }
                    } else {
                        echo "<p>No courses found matching the search parameters.</p>";
                    }
                }
                
            ?>
        </section>

<?php require($INC_DIR . "footer.php"); ?>