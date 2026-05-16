<?php

$stmt = $conn->prepare("SELECT student_id_number, first_name, last_name FROM students WHERE id = ?");
$stmt->bind_param("i", $id);

$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
