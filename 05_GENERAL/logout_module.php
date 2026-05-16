<?php
require("../connection_db.php");
session_start();
$action = "Logged Out";
$role = "admin";
$stmt = $conn->prepare("INSERT INTO history (user,action_performed,role)
                                         VALUES (?,?,?)");
$stmt->bind_param("sss", $_SESSION['name'], $action, $role);
$stmt->execute();

session_unset();
session_destroy();

header("Location: login_module.php");
exit();
