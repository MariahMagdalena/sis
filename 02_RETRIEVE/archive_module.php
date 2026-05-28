<?php

include("../connection_db.php");
include("../header.html");
session_start();
include("../auth.php");
$database = "students_archive";
include('../06_FEATURES/pagination.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="Stylesheet" href="../style.css">
</head>

<body>

     <form method="GET">
        <label for="numrow">Rows per page:</label>
        <select name="numrow" onchange="this.form.submit()">
            <option value="5"
                <?php if ($limit == 5) echo "selected"; ?>>
                5
            </option>
            <option value="10"
                <?php if ($limit == 10) echo "selected"; ?>>
                10
            </option>
            <option value="20"
                <?php if ($limit == 20) echo "selected"; ?>>
                20
            </option>
            <option value="30"
                <?php if ($limit == 30) echo "selected"; ?>>
                30
            </option>
        </select>

    </form>

    <form action="" method="POST">
        <select name="search_column">
            <option value="first_name">Search by Name</option>
            <option value="section">Search by Section</option>
            <option value="course">Search by Course</option>
        </select>

        <input type="text" name="search_value" placeholder="Type here...">

        <button type="submit" name="submit_search">Search</button>
        <a href="archive_module.php"><button type="button">Reset</button></a>


        <h1>Student Archived</h1>
        <table border="1">

            <th>First Name</th>
            <th>Last Name</th>
            <th>Middle Name</th>
            <th>Course</th>
            <th>Section</th>
            <th>Year</th>
            <th>Actions</th>
            <tr>
                <?php
               
                // $query = "SELECT * FROM students_archive";
                $result = mysqli_query($conn, $query);
                while ($row = $result->fetch_assoc()) {
                ?>
            <tr>
                <td><?php echo $row['first_name'] ?></td>
                <td><?php echo $row['last_name'] ?></td>
                <td><?php echo $row['middle_name'] ?></td>
                <td><?php echo $row['course'] ?></td>
                <td><?php echo $row['section'] ?></td>
                <td><?php echo $row['year'] ?></td>
                <td>
                    <!-- Update button -->
                    <a href="../02_RETRIEVE/retrieve_module.php?ID=<?php echo $row['ID']; ?>">Retrieve</a>
                    <!-- Delete button -->
                    <a href="../04_DELETE/permanent_delete_module.php?ID=<?php echo $row['ID']; ?>"
                        onclick="return confirm('Are you sure you want to permanently delete this data?')">Delete</a>
                </td>

            </tr>
        <?php
                }   
        ?>
        </tr>
        </table>
          <?php
        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<a href='welcome_module.php?page=$i&numrow=$limit'>$i</a> ";
        }
        ?>
    </form>

</body>

</html>