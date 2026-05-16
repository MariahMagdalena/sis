<?php
session_start();

include("../connection_db.php");
include("../auth.php");

if (isset($_GET['ID'])) {

    $id = $_GET['ID'];
    $stmt = $conn->prepare("SELECT student_id_number,first_name,last_name 
                        FROM students_archive where id= ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // include("../data_fetching.php");

    $role = "admin";    
    $action = "{$_SESSION['name']} RETRIEVE {$row['first_name']} {$row['last_name']} with Student ID {$row['student_id_number']}";
    include('../06_FEATURES/history_query.php');

    // query for retrieving
    mysqli_query($conn, "INSERT into students SELECT * FROM students_archive where ID='$id'"); //
    $result = mysqli_query($conn, "DELETE from students_archive where ID='$id'");

    if ($result) {
        header("Location: ../05_GENERAL/welcome_module.php");
    } else {
        echo "Failed to retrieve";
    }
}
