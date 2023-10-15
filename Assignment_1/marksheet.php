<!DOCTYPE html>
<html lang="en">

<?php
include "./includes/components/head.php";
include "./includes/util.php";
?>

<body>
    <?php include "./includes/components/nav.php"; ?>

    <main class="container">
        <?php
        if (isset($_GET['roll_number'])) {
            $roll_number = $_GET['roll_number'];
            validateRollNumber($roll_number);
        } else {
            echo "<div class='alert alert-danger my-5 container' role='alert'>
        Roll Number Field must be set.
      </div>";
            die();
        }

        if (!$connection) {
            echo '<div class="alert alert-danger my-5 container" role="alert">' . 'Can not connect to database' . '</div>';
            die();
        } else {
            $roll_number = mysqli_real_escape_string($connection, $roll_number);
        }

        include "./includes/query.php";
        $studentInfo = mysqli_query($connection, $fetch_student_details);
        $row = mysqli_fetch_assoc($studentInfo);
        if (!$row) {
            echo "<div class='alert alert-info my-5 container' role='alert'>
            No Student have roll number $roll_number
          </div>";
            die();
        }

        $name = $row['name'];
        $class = $row['class'];
        $rollNumber = $row['rollNumber'];
        $session = $row['session'];
        $dob = $row['dateOfBirth'];
        $fatherName = $row['fatherName'];
        ?>

        <div class="bordered-div container my-5">
            <h1 class="custom-heading my-3 bg-primary">X University</h1>

            <?php
            include "./includes/components/stu_info.php";
            $marksDetails = mysqli_query($connection, $derived_sql_query);
            if (empty($marksDetails) || mysqli_num_rows($marksDetails) == 0) {
                die();
            }

            include "./includes/components/marks_table.php";

            $aggregatedResult = mysqli_query($connection, $for_final_result);

            $row = mysqli_fetch_assoc($aggregatedResult);
            $totalMarks = $row['TotalMarks'];
            $obtainedMarks = $row['ObtainedMarks'];
            $passingMarks = $row['PassingMarks'];

            include "./includes/components/final_marks.php";
            ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>