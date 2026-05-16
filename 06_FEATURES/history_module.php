<?php
require("../connection_db.php");
include("../header.html");
session_start();
include("../auth.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <table border="1">
        <th>DATE AND TIME</th>
        <th>USER NAME</th>
        <th>ACTION PERFORMED</th>
        <th>ROLE</th>
        <?php

        $query  = "SELECT * from history";
        $result = mysqli_query($conn, $query);
        while ($row = $result->fetch_assoc()) {

        ?>
            <tr>
                
                <td><?php 
                $originalDate = $row['date'];
                $newFormat = date("F j, Y - h:i A", strtotime($originalDate));

                echo $newFormat; ?></td>
                <td><?php echo $row['user']; ?></td>
                <td><?php echo $row['action_performed']; ?></td>
                <td><?php echo $row['role']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>

