<?php
session_start();
include("../connection_db.php");
$error = "";
// kaihugo kaikai
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

            if (password_verify($pass,$row['pass'])) {
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
    <link rel="stylesheet" href="../styles.css">
</head>

<body>
    <div class="login-page">
        <div class="login-main">
            <div class="login-brand">
                <div class="brand-eyebrow"></div>
                <div class="brand-divider"></div>
                <h1>Student Information System</h1>
                <p class="brand-tagline">Access your records, grades, and enrollment details anytime, anywhere.</p>
            </div>

            <div class="login-form-panel">
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
            </div>
        </div>

        <div class="login-footer">
            <span class="footer-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                    <path d="m22 6-10 7L2 6"></path>
                </svg>
                sis@gmail.com
            </span>
            <span class="footer-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z"></path>
                    <circle cx="12" cy="10" r="2.5"></circle>
                </svg>
                Manila, Philippines
            </span>
        </div>
    </div>
</body>

</html>