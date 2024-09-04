<?php
session_start();
if ($_SESSION['role_id'] != 2) {
    header("location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>Staff Dashboard</title>
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container">
        <h2>Staff Dashboard</h2>
        <p>Welcome, Staff!</p>
        <ul>
            <li><a href="inventory.php">Manage Inventory</a></li>
            <li><a href="meal_planning.php">Meal Planning</a></li>
        </ul>
    </div>
    <?php include('../includes/footer.php'); ?>
</body>
</html>
