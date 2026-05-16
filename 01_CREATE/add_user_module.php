<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">
        <label for="fname">Admin Name</label>
        <input type="text" name="adminName" placeholder="Enter Admin name">

        <label for="pass">Password:</label>
        <input type="text" name="pass" placeholder="Enter admin password">

        <input type="submit" value="Enter">
    </form>
</body>
</html>

<?php

?>