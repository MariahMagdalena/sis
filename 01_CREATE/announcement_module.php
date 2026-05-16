<?php
include("../connection_db.php");
include("../header.html");
session_start();
include("../auth.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANNOUCEMENT</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">
        <h4>Add ANNOUCEMENT</h4>
        <input type="text" name="headline" placeholder="Enter Headline">
        <input type="text" name="information" placeholder="Enter information Anoucement">

        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>
<?php
// Headline //information about it
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $headline = $_POST['headline'];
    $information = $_POST['information'];

    if(empty($headline)) echo "Headline must not be empty";
    elseif(empty($information)) echo "Information must not be empty";
    else{
        $stmt = $conn->prepare("INSERT INTO annoucement VALUES (?,?)");
        $stmt->bind_param("ss",$headline,$information);

        if($stmt->execute()){
            echo "Annoucenment Added Successfully!";
            $role = "admin";
            $action = "{$_SESSION['name']} ADDED an Announcement";
            include('../06_FEATURES/history_query.php');

        } else{
            echo "Error inserting annoucement";
        }
    }
}
?>