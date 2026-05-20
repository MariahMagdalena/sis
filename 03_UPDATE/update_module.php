<?php
include("../connection_db.php");
include("../header.html");
session_start();
include("../auth.php");
$id = $_GET['ID'];

// Fetch the record
$result = $conn->query("SELECT * FROM students WHERE id=$id");
$row = $result->fetch_assoc();

$validate = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $mname = $_POST["mname"];
    $course = $_POST["course"];
    $section = $_POST["section"];
    $year = $_POST["year"];
    $stID = $_POST["studentID"];

    if (!preg_match('/^\d{4}-\d{5}-MN-0$/', $stID)) {
        $validate = "Invalid format. Use: YYYY-12345-MN-0";
    } else {
        $action = "{$_SESSION["name"]} UPDATE {$row['first_name']} {$row['last_name']} Information";
        $role = "admin";
        include("../06_FEATURES/history_query.php");

        $conn->query("UPDATE students set 
                                      student_id_number ='$stID',
                                      first_name='$fname', 
                                      last_name='$lname', 
                                      middle_name='$mname', 
                                      course='$course', 
                                      section='$section', 
                                      year='$year'
                                       WHERE ID=$id");
        $_SESSION["message_validation"] = "Student {$fname} {$lname} Updated Successfully!";
        header("Location: ../05_GENERAL/welcome_module.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="POST">
        <label for="fname">First Name</label>
        <input type="text" name="fname" value="<?php echo $row["first_name"]; ?>" required>

        <label for="lname">Last Name</label>
        <input type="text" name="lname" value="<?php echo $row["last_name"]; ?>" required>

        <label for="mname">Middle Name</label>
        <input type="text" name="mname" value="<?php echo $row["middle_name"]; ?>" required>

        <label for="mname">Student Id Number</label>
        <input type="text" name="studentID" placeholder="YYYY-XXXXX-MN-0" value="<?php echo $row["student_id_number"]; ?>" required>

        <label for="course">Course</label>
        <select name="course">
            <option value="DCPET">DCPET</option>
            <option value="DCVET">DCVET</option>
            <option value="DMET">DMET</option>
            <option value="DIT">DIT</option>
        </select>


        <label for="section">Section</label>
        <select name="section">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>

        <label for="year">Year</label>
        <select name="year">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>

        <?php echo $validate; ?>
        <input type="submit" name="submit" value="UPDATE">
    </form>
</body>

</html>