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

    if (!preg_match('/^\d{12}$/', $stID)) {
        $validate = "Invalid LRN. Must contain exactly 12 digits.";
    } else {
        $stmt = $conn->prepare("INSERT INTO students 
                           (student_id_number, first_name, last_name, middle_name, course, section, year) 
                            VALUES (?,?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("sssssss", $stID, $fname, $lname, $mname, $course, $section, $year);

        try { //try catch block to handle duplicate entry of student id number, since it is unique in the database
            if ($stmt->execute()) {
                $validate =  "Student added successfully!";
                $role = 'admin';
                $action = "{$_SESSION['name']} ADDED $fname $mname $lname with student id number of $stID";
                include('../06_FEATURES/history_query.php');
                $_SESSION["message_validation"] = $validate;
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
    <link rel="stylesheet" href="../styles.css">
    <title>ADD</title>
</head>

<body>
    <div class="page-wrapper">
        <div class="form-page-wrapper">
            <div class="form-card">
                <h1>Add New Student</h1>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
        <label for="fname">First Name</label>
        <input type="text" name="fname" value="<?php echo $fname ?>" placeholder="Enter first name" required>

        <label for="lname">Last Name</label>
        <input type="text" name="lname" value="<?php echo $lname ?>" placeholder="Enter last name" required>

        <label for="mname">Middle Name</label>
        <input type="text" name="mname" value="<?php echo $mname ?>" placeholder="Enter middle name" required>

        <label for="mname">Student Id Number</label>
        <input type="text" name="studentID" placeholder="000000000000" required>

        <label for="course">Specialization</label>
        <select name="course">
            <option value="PROGRAMMING" <?php if ($course == "PROGRAMMING")  echo "selected"; ?>>PROGRAMMING</option>
            <option value="COMPUTER SERVICING SYSTEM" <?php if ($course == "COMPUTER SERVICING SYSTEM") echo "selected"; ?>>COMPUTER SERVICING SYSTEM</option>
            <option value="ANIMATION" <?php if ($course == "ANIMATION") echo "selected"; ?>>ANIMATION</option>
            <option value="ELECTRONICS" <?php if ($course == "ELECTRONICS") echo "selected"; ?>>ELECTRONICS</option>
        </select>

        <label for="section">Section</label>
        <select name="section">
            <option value="1" <?php if ($section == "1")  echo "selected"; ?>>1</option>
            <option value="2" <?php if ($section == "2")  echo "selected"; ?>>2</option>
            <option value="3" <?php if ($section == "3")  echo "selected"; ?>>3</option>
        </select>

        <label for="year">Year</label>
        <select name="year">
            <option value="11" <?php if ($year == "11")  echo "selected"; ?>>11</option>
            <option value="12" <?php if ($year == "12")  echo "selected"; ?>>12</option>
        </select>

        <?php if ($validate): ?>
            <p class="validate-msg"><?php echo $validate; ?></p>
        <?php endif; ?>

                    <input type="submit" name="submit" value="Submit">
                </form>
                <a class="back-link" href="../05_GENERAL/welcome_module.php">&larr; Back to student list</a>
            </div>
        </div>
    </div>
</body>

</html>