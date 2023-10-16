<table class="table table-bordered mb-3">
    <thead>
        <tr>
            <th scope="col" class="table-info">Total Marks:</th>
            <td><?php echo $totalMarks; ?></td>
            <th scope="col" class="table-info">Obtained Marks:</th>
            <td scope="col"><?php echo $obtainedMarks; ?></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row" class="table-info">Passing Marks:</th>
            <td><?php echo $passingMarks; ?></td>
            <th class="table-info">Percentage:</th>
            <td><?php echo ($obtainedMarks / $totalMarks) * 100; ?></td>
        </tr>
        <tr>
            <th scope="row">Result:</th>
            <td><?php echo fetchResult($passingMarks, $obtainedMarks); ?></td>
            <th>Grade</th>
            <td><?php echo fetchGrade($obtainedMarks); ?></td>
        </tr>
    </tbody>
</table>