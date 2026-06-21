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
    <link rel="stylesheet" href="../styles.css">
    <title>History</title>
</head>

<body>
    <div class="page-wrapper">
        <div class="page-heading">
            <h1>History Log</h1>
        </div>

        <div class="toolbar-container">
        <div class="toolbar-row-top">
            <input type="text" id="search" placeholder="Search student names…" onkeyup="liveSearch(this.value); updatePdfLink();">
        </div>
</div>
        <div id="results">
            <table border="1">
                <thead>
                    <tr>
                        <th>DATE AND TIME</th>
                        <th>USER NAME</th>
                        <th>ACTION PERFORMED</th>
                        <th>ROLE</th>
                    </tr>
                </thead>
                <tbody>
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
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function liveSearch(query) {
            if (query.length === 0) {
                window.location.href = "history_module.php";
                return;
            }
            fetch("../06_FEATURES/search.php?q=" + encodeURIComponent(query) + "&d=<?php echo 3; ?>")
                .then(r => r.text())
                .then(data => document.getElementById("results").innerHTML = data);
        }
    </script>
</body>

</html>