<?php
session_start();
include("../connection_db.php");
include('../header.html');
// include('../auth.php');
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
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name,email,pass) VALUES (?,?,?)");
        $stmt->bind_param("sss", $adminName, $email, $hashed_password);

        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $action = "{$_SESSION["name"]} ADD new ADMIN with the name of $adminName";
            $role = "admin";
            include("../06_FEATURES/history_query.php");

            $_SESSION["message_validation"] = "New admin added successfully!";
            header("Location: ../05_GENERAL/welcome_module.php");
            exit;
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
    <link rel="stylesheet" href="../styles.css">
    <title>Document</title>
</head>

<body>
    <div class="page-wrapper">
        <div class="form-page-wrapper">
            <div class="form-card">
                <h1>Add New Admin</h1>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                    <label for="fname">Admin Name</label>
                    <input type="text" name="adminName" value="<?php echo $adminName ?>" placeholder="Enter a New Admin Name" required>

                    <label for="email">Email Address:</label>
                    <input type="email" name="email" value="<?php echo $email ?>" placeholder="Enter Admin email address" required>

                    <label for="pass">Password:</label>
                    <input type="password" name="pass" placeholder="Enter Admin password" required>

                    <label for="confirm_pass">Confirm Password:</label>
                    <input type="password" name="confirm_pass" placeholder="Confirm Admin password" required>

                    <input type="submit" name="submit" value="Enter">
                </form>
                <a class="back-link" href="../05_GENERAL/welcome_module.php">&larr; Back to student list</a>
            </div>
        </div>
    </div>
</body>

</html>

<?php

?>