<?php
// search.php
include '../connection_db.php';
$search = $conn->real_escape_string($_GET['q']); // Basic security to prevent SQL injection
$check = $_GET['d']; // Get the database name from the query parameter

if ($check == 1) {
    $database = "students";
} elseif ($check == 2) {
    $database = "students_archive";
} elseif ($check == 3) {
    $database = "history";
    $sql = "SELECT * FROM $database
            WHERE
                user LIKE '%$search%' OR
                action_performed LIKE '%$search%' OR
                role LIKE '%$search%' OR
                date LIKE '%$search%'
    ";
} else {
    echo "Invalid database selection.";
    exit;
}

if ($check != 3) {
    $sql =  "SELECT * FROM $database
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
    echo "<thead>";
    echo "<th>" . "<input type='checkbox' id='select_all' onclick='toggleAll(this)'>" . "</th>";
    echo "<th>" . "First Name" . "</th>";
    echo "<th>" . "Last Name" . "</th>";
    echo "<th>" . "Middle Name" . "</th>";
    echo "<th>" . "Course" . "</th>";
    echo "<th>" . "Section" . "</th>";
    echo "<th>" . "Year" . "</th>";
    echo "<th>" . "Student ID" . "</th>";
    echo "<th>" . "Actions" . "</th>";
    echo "</thead>";
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
        echo "<td colspan='9'>No results found.</td>";
        echo "</tr>";
    }

    echo "</table>";
}

else {

    $result = $conn->query($sql);
    echo "<table>";
    echo "<thead>";
    echo "<th>" . "DATE AND TIME" . "</th>";
    echo "<th>" . "USER NAME" . "</th>";
    echo "<th>" . "ACTION PERFORMED" . "</th>";
    echo "<th>" . "ROLE" . "</th>";
    echo "</thead>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['date'] . "</td>";
            echo "<td>" . $row['user'] . "</td>";
            echo "<td>" . $row['action_performed'] . "</td>";
            echo "<td>" . $row['role'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr>";
        echo "<td colspan='4'>No results found.</td>";
        echo "</tr>";
    }

    echo "</table>";
}
$conn->close();
