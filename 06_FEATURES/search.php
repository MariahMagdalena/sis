<?php
// search.php
include '../connection_db.php';
$search = $conn->real_escape_string($_GET['q']); // Basic security to prevent SQL injection

$sql =  "SELECT * FROM students
        WHERE
            ID LIKE '%$search%' OR
            first_name LIKE '%$search%' OR
            last_name LIKE '%$search%' OR
            middle_name LIKE '%$search%' OR
            course LIKE '%$search%' OR
            section LIKE '%$search%' OR
            student_id_number LIKE '%$search%'
    ";
$result = $conn->query($sql);

echo "<table>";
echo "<th>" . "Select" . "</th>";
echo "<th>" . "First Name" . "</th>";
echo "<th>" . "Last Name" . "</th>";
echo "<th>" . "Middle Name" . "</th>";
echo "<th>" . "Course" . "</th>";
echo "<th>" . "Section" . "</th>";
echo "<th>" . "Year" . "</th>";
echo "<th>" . "Student ID" . "</th>";
echo "<th>" . "Actions" . "</th>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . "<input type='checkbox' name='delete_ids[]' value=" . $row['ID'] . "></td>";
        echo "<td>" . $row['first_name'] . "</td>";
        echo "<td>" . $row['last_name'] . "</td>";
        echo "<td>" . $row['middle_name'] . "</td>";
        echo "<td>" . $row['course'] . "</td>";
        echo "<td>" . $row['section'] . "</td>";
        echo "<td>" . $row['year'] . "</td>";
        echo "<td>" . $row['student_id_number'] . "</td>";
        echo "<td>";
        echo "<a href='../03_UPDATE/update_module.php?ID=" . $row['ID'] . "'>Update</a> ";
        echo "<a href='../04_DELETE/delete_module.php?ID=" . $row['ID'] . "'>Delete</a>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr>";
    echo "<td>" . "No results found." . "</td>";
    echo "</tr>";
}

echo "</table>";
$conn->close();
