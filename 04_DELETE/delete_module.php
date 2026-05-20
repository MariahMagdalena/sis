<?php

include("../connection_db.php");
session_start();
include("../auth.php");
$id = $_GET['ID'];
//need to fetch again the data, beri important tooh 
$result = $conn->query("SELECT * FROM students WHERE id=$id");
// ang laman ng $result is yung mga method to fetch data
$row = $result->fetch_assoc();

if (isset($_GET['ID'])) {

    $student_name = $row['first_name'] . " " . $row['last_name'] . " with student id number of " . $row['student_id_number'];
    mysqli_query($conn, "INSERT INTO students_archive SELECT * FROM students WHERE ID='$id'");
    $query = "DELETE FROM students where ID='$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $role = 'admin';
        $action = "{$_SESSION['name']} PARTIALLY DELETED $student_name ";
        include('../06_FEATURES/history_query.php');
        $_SESSION["message_validation"] = "Student $student_name Deleted Successfully!";
        header("Location: ../05_GENERAL/welcome_module.php");
    } else {
        echo "Delete Failed";
    }
}
