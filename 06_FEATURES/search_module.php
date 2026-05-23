<?php

require("../connection_db.php");
include("../auth.php");
// $query = "SELECT * FROM $database";
$col = "";
$row = "";

if (isset($_POST['submit_search'])) {
    $col = mysqli_real_escape_string($conn, $_POST['search_column']);
    $row = mysqli_real_escape_string($conn, $_POST['search_value']);

    $query = "SELECT * FROM $database WHERE $col LIKE '%$row%'";

}

$result = mysqli_query($conn, $query);

?>
<!-- /Search/Filter: A real-time search bar using the SQL LIKE operator to filter students by
name or course. -->