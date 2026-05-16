<?php

$stmt = $conn->prepare("INSERT INTO history (user,action_performed,role)
                                         VALUES (?,?,?)");
$stmt->bind_param("sss", $_SESSION['name'], $action, $role);
$stmt->execute();
?>