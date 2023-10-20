<?php
$db['db_host'] = "localhost";
$db['db_user'] = "root";
$db['db_password'] = "";
$db['db_database'] = "students";

$constants = get_defined_constants();

foreach ($db as $key => $value) {
    if (!array_key_exists(strtoupper($key), $constants)) {
        define(strtoupper($key), $value);
    }
}

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
if ($connection == false) {
    $error_message = mysqli_connect_error();
    die("Can't connect to the database because: " . $error_message);
}
