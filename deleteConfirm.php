<?php
    $getUserID = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation</title>
</head>
<body>
    <h2>Are you sure you want to delete this account?</h2>
    <a href="delete.php?id=<?= $getUserID ?>">Yes</a> or <a href="viewRecords.php">No</a>
</body>
</html>
