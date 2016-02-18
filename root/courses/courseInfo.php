<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    session_start();
    require_once($INC_DIR . "header.php");
    require_once($INC_DIR . "top-navbar.php");
    require_once("course.php");
    require_once("../books/bookLookup.php");

?>
<?php
    if($_SERVER["REQUEST_METHOD"] == "GET") {
        $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }

        $courseID = mysqli_real_escape_string($link, $_GET['courseID']); //sanitize courseID input
        
        $course_query = mysqli_query($link, "SELECT * FROM courses WHERE Course_Code='$courseID'");
        
        $course = new Course;
        
        if ($course_query != null) {
            while($row = mysqli_fetch_array($course_query)) {
                $course->setCourseCode($row['Course_Code']);
                $course->setCourseDesc($row['Course_Desc']);
                $course->addSprint($row['Sprint']);
                $course->addSection($row['Section']);
                $course->setCredits($row['Credits']);
                $course->addStartTime($row['Start_Time']);
                $course->addEndTime($row['End_Time']);
                $course->setDaysTaught($row['Days_Taught']);
                $course->addInstructor($row['Instructor']);
                $course->setFirstISBNTenCode($row['ISBN_One_v10']);
                $course->setFirstISBNThirteenCode($row['ISBN_One_v13']);
                $course->setSecondISBNTenCode($row['ISBN_Two_v10']);
                $course->setSecondISBNThirteenCode($row['ISBN_Two_v13']);
            }
        }
        
        $textbooks = [];
        $_SESSION['TEXTBOOKS'] = $textbooks;
        
        //Check to see if ISBN 10/13 is set for the first textbook (Should either always return a result or have no result)
        if (!empty($course->getFirstISBNTenCode()) && $course->getFirstISBNTenCode() != null) {
            $textbook_query_one = mysqli_query($link, "SELECT * FROM textbooks WHERE ISBN_v10='{$course->getFirstISBNTenCode()}'");
            $first_text = mysqli_fetch_array($textbook_query_one);
            if ($first_text != null) {
                array_push($textbooks, $first_text);
            }                              
        } else {
            $textbook_query_one = mysqli_query($link, "SELECT * FROM textbooks WHERE ISBN_v13='{$course->getFirstISBNThirteenCode()}'");
            $first_text = mysqli_fetch_array($textbook_query_one);
            if ($first_text != null) {
                array_push($textbooks, $first_text);
            } 
        }
                                               
        //Check to see if ISBN 10/13 is set for the second textbook (Should either always have no result or occasionally have a result)                                       
        if (!empty($course->getSecondISBNTenCode()) && $course->getSecondISBNTenCode() != null) {
            $textbook_query_two = mysqli_query($link, "SELECT * FROM textbooks WHERE ISBN_v10='{$course->getSecondISBNTenCode()}'");
            $second_text = mysqli_fetch_array($textbook_query_two);
            if ($second_text != null) {
                array_push($textbooks, $second_text);
            }                              
        } else {
            $textbook_query_two = mysqli_query($link, "SELECT * FROM textbooks WHERE ISBN_v13='{$course->getSecondISBNThirteenCode()}'");
            $second_text = mysqli_fetch_array($textbook_query_two);
            if ($second_text != null) {
                array_push($textbooks, $second_text);
            } 
        }
        
        $_SESSION['COURSE_INFO'] = $course;
        $_SESSION['TEXTBOOKS'] = $textbooks;
        mysqli_close($link);
    }
?>
        <section class="info">
            <a class="return" href="../courses/search.php">&#10094; Return to Course Search Page</a>
            <h1>
                <?php
                    echo $_SESSION['COURSE_INFO']->getCourseCode() . " - " . $_SESSION["COURSE_INFO"]->getCourseDesc() . "<hr/>";
                ?>
            </h1>
            <h2>
                <?php
                    echo "Taught ";
                    $sprints =  $_SESSION['COURSE_INFO']->getSprints();
                    if (isset($sprints[1]) && !empty($sprints[1])) {
                        echo "Sprints 1 and 2";    
                    } else {
                        if ($sprints[0] == 1) {
                            echo "Sprint 1";
                        } else if($sprints[0] == 2) {
                            echo "Sprint 2";
                        } else {
                            echo "Quarter Long";
                        }
                    }
                ?>
            </h2>
            <h2><?php echo (count($_SESSION["COURSE_INFO"]->getInstructors()) > 1) ? "Instructors" : "Instructor"; ?></h2>
            <ul>
                <?php
                    foreach($_SESSION["COURSE_INFO"]->getInstructors() as $instructor) {
                        if (!empty($instructor)) {
                            echo '<li class="instructor">'.$instructor.'</li>';
                        }
                        
                    }
                ?>
            </ul>
            <h2>
                <?php
                    echo ((count($_SESSION["TEXTBOOKS"]) == 0) ? "No " : "") . "Required/Recommended " . ((count($_SESSION["TEXTBOOKS"]) > 1) ? "Textbooks" : "Textbook");
                ?>
            </h2>
            <ul>
                <?php
                    //Amazon Web Service API Implementation
                    $s3 = new Aws\S3\S3Client([
                        'version' => 'latest',
                        'region' => 'us-west-2'
                    ]);

                    $sharedConfig = [
                        'region' => 'us-west-2',
                        'version' => 'latest'
                    ];

                    $sdk = new Aws\Sdk($sharedConfig);
                    $client = $sdk->createS3();
                    
                    foreach($_SESSION["TEXTBOOKS"] as $textbook) {
                        if (!empty($textbook) && $textbook != null) {
                            $isbn_used = "";//(!empty($textbook['ISBN_v10'])) ? substr($textbook['ISBN_v10'], 8) : substr($textbook['ISBN_v13'], 11);
                            $linkId = "";
                            echo '<li class="book-result custom-box-shadow">';
                            $lookup = null;
                            $thumbnail_url = "";
                            if (!empty($textbook['ISBN_v10'])) {
                                $isbn_used = substr($textbook['ISBN_v10'], 8);
                            } else if ($lookup == null && !empty($textbook['ISBN_v13'])) {
                                $isbn_used = substr($textbook['ISBN_v13'], 11);
                            }
                            
                            $lookup = BookLookup::runGoogleBooksRESTCall($isbn_used);
                            if ($lookup['totalItems'] == 0) {
                                $lookup = null;
                                $thumbnail_url = "../assets/images/smallThumbnailPlaceholder.png";
                            } else if ($lookup != null) {
                                $thumbnail_url = BookLookup::returnSmallThumbnailURL($lookup);
                            }
                            $price_tag = BookLookup::returnBookPrice($lookup);
                            echo '<aside><img class="thumbnail" src="'.$thumbnail_url.'"/></aside>';
                            
                            echo '<aside><p><a rel="nofollow" href="http://www.amazon.com/gp/product/' . $isbn_used . '/ref=as_li_tl?ie=UTF8&camp=1789&creative=9325&creativeASIN=' . $isbn_used . '&linkCode=as2&tag=book0920-20&linkId=CT2AYIAC6JDFTZV4" target="blank">' . $textbook['Text_Name'] . '</a></p>'; //return link to amazon product page
                            echo '<p> Author: ' . $textbook['Primary_Author'] . '</p>'; //book author
                            echo '<p>'.$price_tag.'</p></aside>'; //book price (if available)
                            
                            echo '</li>';
                            
                        }
                        
                    }
                ?>
            </ul>
        </section>

<?php require($INC_DIR . "footer.php"); ?>
