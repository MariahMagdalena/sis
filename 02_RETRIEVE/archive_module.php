<?php

include("../connection_db.php");
include("../header.html");
session_start();
include("../auth.php");
$database = "students_archive";
include('../06_FEATURES/pagination.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="Stylesheet" href="../styles.css">
</head>

<body>
    <div class="page-wrapper">
        <div class="page-heading">
            <h1>Student Archived</h1>
        </div>

        <div class="toolbar-container">
            <form action="" method="POST" class="toolbar-row-top">
                <input type="text" id="search" placeholder="Search names..." onkeyup="liveSearch(this.value)">
            </form>
            <div class="toolbar-row-bottom">
                <div class="controls-left">
                    <form method="GET" class="table-controls-bottom">
                        <label for="numrow" class="rows-label">Rows per page:</label>
                        <select name="numrow" onchange="this.form.submit()">
                            <option value="5"
                                <?php if ($limit == 5) echo "selected"; ?>>
                                5
                            </option>
                            <option value="10"
                                <?php if ($limit == 10) echo "selected"; ?>>
                                10
                            </option>
                            <option value="20"
                                <?php if ($limit == 20) echo "selected"; ?>>
                                20
                            </option>
                            <option value="30"
                                <?php if ($limit == 30) echo "selected"; ?>>
                                30
                            </option>
                        </select>
                    </form>

                </div>
            </div>
        </div>

        <div id="results">
            <table border="1">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Middle Name</th>
                        <th>Course</th>
                        <th>Section</th>
                        <th>Year</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    // $query = "SELECT * FROM students_archive";
                    $result = mysqli_query($conn, $query);
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo $row['first_name'] ?></td>
                            <td><?php echo $row['last_name'] ?></td>
                            <td><?php echo $row['middle_name'] ?></td>
                            <td><?php echo $row['course'] ?></td>
                            <td><?php echo $row['section'] ?></td>
                            <td><?php echo $row['year'] ?></td>
                            <td>
                                <!-- Update button -->
                                <div class="row-actions">
                                    <a name="retrieve_module" href="../02_RETRIEVE/retrieve_module.php?ID=<?php echo $row['ID']; ?>">Retrieve</a>
                                    <!-- Delete button -->
                                    <a name="delete_module" href="../04_DELETE/permanent_delete_module.php?ID=<?php echo $row['ID']; ?>"
                                        onclick="return confirm('Are you sure you want to permanently delete this data?')">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <?php
            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<a href='archive_module.php?page=$i&numrow=$limit'>$i</a>";
            }
            ?>
        </div>
    </div>
    <script>
        function liveSearch(query) {
            if (query.length == 0) {
                window.location.href = "archive_module.php";
                return;
            }
            // AJAX request to PHP script

            fetch("../06_FEATURES/search.php?q=" + query + "&d=<?php echo 2; ?>")
                .then(response => response.text())
                .then(data => {
                    document.getElementById("results").innerHTML = data;
                });
        }
    </script>
</body>

</html>