<?php

session_start();
include("../connection_db.php");
include("../header.html");
include("../auth.php");

$lname =  "";
$fname =  "";
$mname =  "";
$course =  "";
$section =  "";
$year = "";
$stID = "";


$validate = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = trim($_POST["fname"]);
    $lname = trim($_POST["lname"]);
    $mname = trim($_POST["mname"]);
    $course = trim($_POST["course"]);
    $section = trim($_POST["section"]);
    $year = trim($_POST["year"]);
    $stID = trim($_POST['studentID']);

    if (!preg_match('/^\d{4}-\d{5}-MN-0$/', $stID)) {
        $validate = "Invalid format. Use: YYYY-12345-MN-0";
    } else {
        $stmt = $conn->prepare("INSERT INTO students 
                           (student_id_number, first_name, last_name, middle_name, course, section, year) 
                            VALUES (?,?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("sssssss", $stID, $fname, $lname, $mname, $course, $section, $year);

        try {
            if ($stmt->execute()) {
                $validate =  "Student added successfully!";
                $role = 'admin';
                $action = "{$_SESSION['name']} ADDED $fname $mname $lname with student id number of $stID";
                include('../06_FEATURES/history_query.php');
                header("Location: ../05_GENERAL/welcome_module.php");
                exit();
            } else {
                echo "Error inserting data";
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                $validate = "The Student ID is already Used by other Students";
            } else {
                echo "Error here" . $e->getMessage();
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD</title>
</head>

<body>
    <h1>ADD NEW STUDENTS</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
        <label for="fname">First Name</label>
        <input type="text" name="fname" value="<?php echo $fname ?>" placeholder="Enter first name" required>

        <label for="lname">Last Name</label>
        <input type="text" name="lname" value="<?php echo $lname ?>" placeholder="Enter last name" required>

        <label for="mname">Middle Name</label>
        <input type="text" name="mname" value="<?php echo $mname ?>" placeholder="Enter middle name" required>

        <label for="mname">Student Id Number</label>
        <input type="text" name="studentID" placeholder="YYYY-XXXXX-MN-0" required>

        <label for="course">Course</label>
        <select name="course">
            <option value="DCPET" <?php if ($course == "DCPET")  echo "selected"; ?>>DCPET</option>
            <option value="DCVET" <?php if ($course == "DCVET") echo "selected"; ?>>DCVET</option>
            <option value="DMET" <?php if ($course == "DMET") echo "selected"; ?>>DMET</option>
            <option value="DIT" <?php if ($course == "DIT") echo "selected"; ?>>DIT</option>
        </select>

        <label for="section">Section</label>
        <select name="section">
            <option value="1" <?php if ($section == "1")  echo "selected"; ?>>1</option>
            <option value="2" <?php if ($section == "2")  echo "selected"; ?>>2</option>
            <option value="3" <?php if ($section == "3")  echo "selected"; ?>>3</option>
        </select>

        <label for="year">Year</label>
        <select name="year">
            <option value="1" <?php if ($year == "2")  echo "selected"; ?>>1</option>
            <option value="2" <?php if ($year == "2")  echo "selected"; ?>>2</option>
            <option value="3" <?php if ($year == "2")  echo "selected"; ?>>3</option>
        </select>

        <?php echo $validate; ?>

        <input type="submit" name="submit" value="Submit">
    </form>
</body>

</html>