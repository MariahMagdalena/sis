<?php
session_start();
include("../connection_db.php");
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $pass = trim($_POST["password"]);

    if (empty($name)) {
        $error = "Username must not be empty";
    } elseif (empty($pass)) {
        $error = "Password must not be empty";
    } else {
        $stmt = $conn->prepare("SELECT pass FROM users WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if ($pass == $row['pass']) {
                $_SESSION["name"] = $name;
                $_SESSION["message_validation"] = "";
                $action = "Logged In";
                $role = "admin";

                include("../06_FEATURES/history_query.php");

                header("Location: welcome_module.php");
                exit;
            } else {
                $error = "Invalid Password";
            }

        } else {
            $error = "Invalid Username";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body style="display: flex;">
    <div class="login-container">
        <h2>Login</h2>
        <?php
        if (!empty($error)) {
        ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php } ?>
        <form action="login_module.php" method="POST">
            <label for="name">Username</label>
            <input type="text" name="name" placeholder="Enter your username" required>

            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>

            <input type="submit" name="Log In" value="Login">
        </form>
    </div>
</body>

</html>