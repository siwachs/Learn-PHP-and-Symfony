<?php
function validateRollNumber($roll_number)
{
    if ($roll_number === "" || empty($roll_number)) {
        echo "<div class='alert alert-danger my-5 container' role='alert'>
    Roll Number can not be empty.
  </div>";
        die();
    } elseif (!is_numeric($roll_number)) {
        echo "<div class='alert alert-danger my-5 container' role='alert'>
    Roll Number must be a number.
  </div>";
        die();
    }
}

function fetchGrade($obtainedMarks)
{
    $gradeLookup = [
        400 => 'A',
        300 => 'B',
        200 => 'C'
    ];
    foreach ($gradeLookup as $marks => $grade) {
        if ($obtainedMarks >= $marks) {
            return $grade;
        }
    }
    return 'F';
}

function fetchResult($passingMarks, $obtainedMarks)
{
    return $obtainedMarks >= $passingMarks ? "PASS" : "FAIL";
}
