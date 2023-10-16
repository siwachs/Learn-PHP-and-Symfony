<?php
$fetch_student_details = "SELECT * FROM `students` WHERE rollNumber=$roll_number";

$base_sql_query = "SELECT students.rollNumber, students.name, students.fatherName, students.class, students.dateOfBirth, students.session,  subjectmarks.subject, subjectmarks.totalMarks, subjectmarks.passingMarks, subjectmarks.marksObtained, subjectmarks.grade
FROM students
JOIN subjectmarks ON students.rollNumber = subjectmarks.rollNumber
WHERE students.rollNumber = $roll_number";

$derived_sql_query = "SELECT subjectmarks.subject, subjectmarks.totalMarks, subjectmarks.passingMarks, subjectmarks.marksObtained, subjectmarks.grade
FROM students
JOIN subjectmarks ON students.rollNumber = subjectmarks.rollNumber
WHERE students.rollNumber = $roll_number";

$for_final_result = "SELECT SUM(subjectmarks.totalMarks) AS TotalMarks, SUM(subjectmarks.marksObtained) AS ObtainedMarks, 300 AS PassingMarks FROM students
JOIN subjectmarks ON students.rollNumber = subjectmarks.rollNumber
WHERE students.rollNumber = $roll_number";
