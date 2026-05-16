<?php
session_start();
include("../connection_db.php");
include("../header.html");
include("../auth.php");
$database = "students";
include('../06_FEATURES/pagination.php');


if (isset($_POST['delete_selected'])) {
    if (!empty($_POST['delete_ids'])) {

        $ids = $_POST['delete_ids'];

        foreach ($ids as $id) { //history query to add multiple action of delete 
            $stmt = $conn->prepare("SELECT student_id_number, first_name, last_name FROM students WHERE id = ?");
            $stmt->bind_param("i", $id);

            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            $role = "admin";
            $action = "{$_SESSION['name']} PARTIALLY DELETED {$row['first_name']} {$row['last_name']} with Student ID of {$row['student_id_number']}";
            include('../06_FEATURES/history_query.php');
        }


        $ids = implode(",", $ids); // convert array to string
        mysqli_query($conn, "INSERT INTO students_archive SELECT * FROM students WHERE ID IN ($ids)");
        $delete_query = "DELETE FROM students WHERE ID IN ($ids)";
        mysqli_query($conn, $delete_query);

        echo "<script>alert('Selected students deleted'); window.location.href='welcome_module.php';</script>";
    } else {
        echo "<script>alert('No student selected');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WELCOME</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <?php
    echo "Welcome {$_SESSION["name"]}";
    ?>

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
        <a href="welcome_module.php"><button type="button">Reset</button></a>

        <button type="submit" name="delete_selected" onclick="return confirm('Delete Selected Students?')">Delete Selected</button>

        <h1>Students that are currently Enrolled</h1>
        <table border="1">
            <th>Select</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Middle Name</th>
            <th>Course</th>
            <th>Section</th>
            <th>Year</th>
            <th>Student Id #</th>
            <th>Actions</th>
            
                <?php
                include('../06_FEATURES/search_module.php');
                // search module to nasa seperated file para reusable 👍👍👍
                while ($row = $result->fetch_assoc()) {
                ?>
            <tr>
                <td><input type="checkbox" name="delete_ids[]" value="<?php echo $row['ID']; ?>"></td>
                <td><?php echo $row['first_name'] ?></td>
                <td><?php echo $row['last_name'] ?></td>
                <td><?php echo $row['middle_name'] ?></td>
                <td><?php echo $row['course'] ?></td>
                <td><?php echo $row['section'] ?></td>
                <td><?php echo $row['year'] ?></td>
                <td><?php echo $row['student_id_number'] ?></td>
                <td>
                    <!-- Update button -->
                    <a href="../03_UPDATE/update_module.php?ID=<?php echo $row['ID']; ?>">Update</a>
                    <!-- Delete button -->
                    <a href="../04_DELETE/delete_module.php?ID=<?php echo $row['ID']; ?>"
                        onclick="return confirm('Are you sure?')">Delete</a>
                </td>

            </tr>
        <?php
                }
        ?>
     
        </table>
        <?php
        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<a href='welcome_module.php?page=$i&numrow=$limit'>$i</a> ";
        }
        ?>
    </form>

    <h1>Important Announcement</h1>
    <?php
    $query1 = "SELECT * FROM annoucement";
    $result = mysqli_query($conn, $query1);
    ?>
    <div class="announce_wrapper">

        <?php
        while ($row = $result->fetch_assoc()) {
        ?>
            <div class="announce_content">
                <?php
                echo "<h1> {$row['headline']}</h1> ";
                ?>
                <div class="annouce_content1">
                    <?php
                    echo "<h2> {$row['information']} </h2>"
                    ?>
                </div>
            </div>

        <?php } ?>
    </div>
</body>

</html>