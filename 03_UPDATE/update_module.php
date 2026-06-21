<?php
include("../connection_db.php");
include("../header.html");
session_start();
include("../auth.php");
$id = $_GET['ID'];

// Fetch the record
$result = $conn->query("SELECT * FROM students WHERE id=$id");
$row = $result->fetch_assoc();
$course =  "";
$section =  "";
$year = "";
$validate = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $mname = $_POST["mname"];
    $course = $_POST["course"];
    $section = $_POST["section"];
    $year = $_POST["year"];
    $stID = $_POST["studentID"];
    if (!preg_match('/^\d{12}$/', $stID)) {
        $validate = "Invalid LRN. Must contain exactly 12 digits.";
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
    <link rel="stylesheet" href="../styles.css">
    <title>Document</title>
</head>

<body>
    <div class="page-wrapper">
        <div class="form-page-wrapper">
            <div class="form-card">
                <h1>Update Student</h1>
                <form action="" method="POST">
                    <label for="fname">First Name</label>
                    <input type="text" name="fname" value="<?php echo $row["first_name"]; ?>" required>

                    <label for="lname">Last Name</label>
                    <input type="text" name="lname" value="<?php echo $row["last_name"]; ?>" required>

                    <label for="mname">Middle Name</label>
                    <input type="text" name="mname" value="<?php echo $row["middle_name"]; ?>" required>

                    <label for="mname">Student Id Number</label>
                    <input type="text" name="studentID" placeholder="YYYY-XXXXX-MN-0" value="<?php echo $row["student_id_number"]; ?>" required>

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
                    <input type="submit" name="submit" value="UPDATE">
                </form>
                <a class="back-link" href="../05_GENERAL/welcome_module.php">&larr; Back to student list</a>
            </div>
        </div>
    </div>
</body>

</html>