<?php
include("../connection_db.php");
$limit = 5;

if (isset($_GET['numrow'])) {
    $limit = (int) $_GET['numrow'];
    //echo $limit;
}

$page = 1;

if(isset($_GET['page'])) {
    $page = (int) $_GET['page'];
}

$start = ($page-1) * $limit;

$query = "SELECT * FROM $database LIMIT $start, $limit";
$result = mysqli_query($conn, $query);

$total_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM $database");
$total_row = mysqli_fetch_assoc($total_result);
$total_pages = ceil($total_row['total'] / $limit);

