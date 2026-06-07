<?php
include 'connection_db.php';
if(isset($_POST['submit'])) {
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    $url = 
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, proceed with password reset
        // You can generate a reset token and send an email to the user with the reset link
        echo "A password reset link has been sent to your email address.";
    } else {
        // User does not exist
        echo "No account found with that email address.";
    }
}

?>