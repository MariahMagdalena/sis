<?php

include("../connection_db.php");
session_start();
include("../auth.php");
$id = $_GET['ID'];
$result = $conn->query("SELECT * from students_archive WHERE id = $id");
$row = $result->fetch_assoc();
$student_name = $row['first_name'] . " " . $row['last_name'] . " with student id number of " . $row['student_id_number'];
echo $student_name;
if (isset($_GET['ID'])) {

    $new_result = mysqli_query($conn, "DELETE FROM students_archive where ID='$id'");

    if ($new_result) {
        $role = 'admin';
        $action = "{$_SESSION['name']} PERMANENTLY DELETED $student_name";
        include('../06_FEATURES/history_query.php');
        header("Location: ../05_GENERAL/welcome_module.php");
    } else {
        echo "Failed to permanently delete";
    }
}
