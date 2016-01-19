<?php
//require_once("../dependencies/underscore.php");

//$underscore = new __;

class Course {
    private $course_code = "";
    private $course_desc = "";
    private $sprints = [];
    private $sections = [];
    private $credits = 0;
    private $start_times = [];
    private $end_times = [];
    private $days_taught = "";
    private $instructors = [];
    private $isbn_1_10 = "";
    private $isbn_1_13 = "";
    private $isbn_2_10 = "";
    private $isbn_2_13 = "";

    public function __construct() {
        
    }
    
//    private function setStartTimesArray() {
//        $this->start_times = [];
//    }
//    
//    private function setEndTimesArray() {
//        $this->end_times = [];
//    }

    function setCourseCode($courseCode) {
        if($this->course_code != $courseCode) {
            $this->course_code = $courseCode;
        }
    }

    function getCourseCode() {
        return $this->course_code;
    }

    function setCourseDesc($courseDesc) {
        if($this->course_desc != $courseDesc) {
            $this->course_desc = $courseDesc;
        }
    }

    function getCourseDesc() {
        return $this->course_desc;
    }

    function addSprint($sprintCode) {
        if (!in_array($sprintCode, $this->sprints)) {
            array_push($this->sprints, $sprintCode);
        }
    }

    function getSprints() {
        return $this->sprints;
    }

    function addSection($sectionCode) {
        array_push($this->sections, $sectionCode);
    }

    function getSections() {
        return $this->sections;
    }
    
    function setCredits($credits) {
        if($this->credits === $credits) {
            $this->credits = $credits;
        }
    }

    function getCredits() {
        return $this->credits;
    }
    
    function addStartTime($startTime) {
        array_push($this->start_times, $startTime);
    }
    
    function getStartTimes() {
        return $this->start_times;
    }
    
    function addEndTime($endTime) {
        array_push($this->end_times, $endTime);
    }
    
    function getEndTimes() {
        return $this->end_times;
    }
    
    function setDaysTaught($daysTaught) {
        if($this->days_taught != $daysTaught) {
            $this->days_taught = $daysTaught;
        }
    }

    function getDaysTaught() {
        return $this->days_taught;
    }

    function addInstructor($instructor) {
        if (!in_array($instructor, $this->instructors)) {
            array_push($this->instructors, $instructor);
        }
    }

    function getInstructors() {
        return $this->instructors;
    }
    
    function setFirstISBNTenCode($ISBNv10) {
        if($this->isbn_1_10 != $ISBNv10) {
            $this->isbn_1_10 = $ISBNv10;
        }
    }

    function getFirstISBNTenCode() {
        return $this->isbn_1_10;
    }

    function setFirstISBNThirteenCode($ISBNv13) {
        if($this->isbn_1_13 != $ISBNv13) {
            $this->isbn_1_13 = $ISBNv13;
        }
    }

    function getFirstISBNThirteenCode() {
        return $this->isbn_1_13;
    }
    
    function setSecondISBNTenCode($ISBNv10) {
        if($this->isbn_2_10 != $ISBNv10) {
            $this->isbn_2_10 = $ISBNv10;
        }
    }

    function getSecondISBNTenCode() {
        return $this->isbn_2_10;
    }

    function setSecondISBNThirteenCode($ISBNv13) {
        if($this->isbn_2_13 != $ISBNv13) {
            $this->isbn_2_13 = $ISBNv13;
        }
    }

    function getSecondISBNThirteenCode() {
        return $this->isbn_2_13;
    }
}

?>