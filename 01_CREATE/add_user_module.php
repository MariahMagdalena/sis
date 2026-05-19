<?php
session_start();
include("../connection_db.php");
include('../header.html');
include('../auth.php');
$adminName = "";
$pass = "";
$confirm_pass = "";
$email = "";

if (isset($_POST['submit'])) {
    $adminName = $_POST['adminName'];
    $pass = $_POST['pass'];
    $confirm_pass = $_POST['confirm_pass'];
    $email = $_POST['email'];

    if ($pass == $confirm_pass) {
        $stmt = $conn->prepare("INSERT INTO users (name,email,pass) VALUES (?,?,?)");
        $stmt->bind_param("sss", $adminName, $email, $pass);

        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            echo "<script>alert('New admin added successfully'); window.location.href='../welcome_module.php';</script>";
        } else {
            echo "<script>alert('Failed to add new admin');</script>";
        }
    } else {
        echo "Passwords do not match.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Document</title>
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
        <label for="fname">Admin Name</label>
        <input type="text" name="adminName" value="<?php echo $adminName ?>" placeholder="Enter a New Admin Name" required>

        <label for="email">Email Address:</label>
        <input type="email" name="email" value="<?php echo $email ?>" placeholder="Enter Admin email address" required>

        <label for="pass">Password:</label>
        <input type="password" name="pass" value="<?php echo $pass ?>" placeholder="Enter Admin password" required>

        <label for="confirm_pass">Confirm Password:</label>
        <input type="password" name="confirm_pass" value="<?php echo $confirm_pass ?>" placeholder="Confirm Admin password" required>

        <input type="submit" name="submit" value="Enter">
    </form>
</body>

</html>

<?php

?>