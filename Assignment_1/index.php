<!DOCTYPE html>
<html lang="en">

<?php include "./includes/components/head.php"; ?>

<body>
    <?php include "./includes/components/nav.php"; ?>

    <main class="container">
        <?php include "./includes/components/form.php"; ?>

        <?php
        if (isset($_POST['submit'])) {
            $roll_number = $_POST['roll_number'];
            if ($roll_number !== "" || !empty($roll_number)) {
                header("Location: marksheet.php?roll_number=" . $_POST['roll_number']);
            }
        }
        ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>