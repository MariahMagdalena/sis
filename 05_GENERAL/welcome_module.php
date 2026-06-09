<?php
session_start();
include("../connection_db.php");
include("../header.html");
include("../auth.php");
$database = "students";
include('../06_FEATURES/pagination.php');

if (isset($_POST['delete_selected'])) {
    if (!empty($_POST['delete_ids'])) {
        $ids = $_POST['delete_ids'];
        foreach ($ids as $id) {
            $stmt = $conn->prepare("SELECT student_id_number, first_name, last_name FROM students WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row    = $result->fetch_assoc();

            $role   = "admin";
            $action = "{$_SESSION['name']} PARTIALLY DELETED {$row['first_name']} {$row['last_name']} with Student ID of {$row['student_id_number']}";
            include('../06_FEATURES/history_query.php');
        }

        $ids = implode(",", $ids);
        mysqli_query($conn, "INSERT INTO students_archive SELECT * FROM students WHERE ID IN ($ids)");
        mysqli_query($conn, "DELETE FROM students WHERE ID IN ($ids)");

        echo "<script>alert('Selected students deleted'); window.location.href='welcome_module.php';</script>";
    } else {
        echo "<script>alert('No student selected');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List — PUP</title>
    <link rel="stylesheet" href="../styles.css">
</head>

<body>

    <div class="page-wrapper">

        <div class="welcome-banner">
            <div class="avatar"><?php echo strtoupper(substr($_SESSION['name'], 0, 1)); ?></div>
            <div class="text">
                <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
                <p>Polytechnic University of the Philippines — Student Information System</p>
            </div>
        </div>

        <form action="" method="POST">

            <div class="toolbar-container">
                <div class="toolbar-row-top">
                    <input type="text" id="search" placeholder="Search student names…" onkeyup="liveSearch(this.value); updatePdfLink();">
                </div>

                <div class="toolbar-row-bottom">

                    <div class="controls-left">
                        <span class="rows-label">Rows per page:</span>
                        <select name="numrow" onchange="location.href='welcome_module.php?numrow='+this.value;">
                            <option value="5" <?php if ($limit == 5)  echo "selected"; ?>>5</option>
                            <option value="10" <?php if ($limit == 10) echo "selected"; ?>>10</option>
                            <option value="20" <?php if ($limit == 20) echo "selected"; ?>>20</option>
                            <option value="30" <?php if ($limit == 30) echo "selected"; ?>>30</option>
                        </select>

                        <a href="welcome_module.php" class="btn-reset">↺ Reset</a>

                        <button type="submit" name="delete_selected" onclick="return confirm('Delete selected students?')">
                            🗑 Delete Selected
                        </button>
                    </div>

                    <a href="../pdf_generate.php" id="pdfLink">⬇ Download PDF</a>

                </div>
            </div>

            <h1>Currently Enrolled Students</h1>

            <?php
            if (!empty($_SESSION['message_validation'])) {
                echo "<div id='msg'>✔ {$_SESSION['message_validation']}</div>";
                unset($_SESSION['message_validation']);
            }
            ?>

            <div id="results">
                <table>
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select_all" onclick="toggleAll(this)"></th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Middle Name</th>
                            <th>Course</th>
                            <th>Section</th>
                            <th>Year</th>
                            <th>Student ID #</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><input type="checkbox" name="delete_ids[]" value="<?php echo $row['ID']; ?>"></td>
                                <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['middle_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['course']); ?></td>
                                <td><?php echo htmlspecialchars($row['section']); ?></td>
                                <td><?php echo htmlspecialchars($row['year']); ?></td>
                                <td><?php echo htmlspecialchars($row['student_id_number']); ?></td>
                                <td>
                                    <a href="../03_UPDATE/update_module.php?ID=<?php echo $row['ID']; ?>">Edit</a>
                                    <a href="../04_DELETE/delete_module.php?ID=<?php echo $row['ID']; ?>"
                                        onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- ── Pagination ───────────────────────────────── -->
            <div class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="welcome_module.php?page=<?php echo $i; ?>&numrow=<?php echo $limit; ?>"
                        <?php if (isset($page) && $page == $i) echo 'class="active"'; ?>>
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>

        </form>
    </div><!-- /page-wrapper -->

    <script>
        function updatePdfLink() {
            const val = document.getElementById("search").value;
            document.getElementById("pdfLink").href =
                "../pdf_generate.php?search_val=" + encodeURIComponent(val);
        }
        updatePdfLink();

        function toggleAll(source) {
            document.querySelectorAll('input[name="delete_ids[]"]')
                .forEach(cb => cb.checked = source.checked);
        }

        const msg = document.getElementById("msg");
        if (msg) setTimeout(() => msg.style.display = "none", 4000);

        function liveSearch(query) {
            if (query.length === 0) {
                window.location.href = "welcome_module.php";
                return;
            }
            fetch("../06_FEATURES/search.php?q=" + encodeURIComponent(query))
                .then(r => r.text())
                .then(data => document.getElementById("results").innerHTML = data);
        }
    </script>

</body>

</html>