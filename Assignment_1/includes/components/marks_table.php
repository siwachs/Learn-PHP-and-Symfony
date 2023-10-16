<table class="table table-bordered mb-3">
    <thead>
        <tr>
            <th scope="col" class="table-success">Subjects</th>
            <th scope="col" class="table-success">Total Marks</th>
            <th scope="col" class="table-success">Passing Marks</th>
            <th scope="col" class="table-success">Marks Obtained</th>
            <th scope="col" class="table-success">Grade</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($marksDetails)) {
            $subject = $row['subject'];
            $totalMarks = $row['totalMarks'];
            $passingMarks = $row['passingMarks'];
            $marksObtained = $row['marksObtained'];
            $grade = $row['grade'];

            include "./includes/components/marks_info.php";
        }
        ?>
    </tbody>
</table>