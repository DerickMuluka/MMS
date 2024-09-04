<?php
session_start();
if ($_SESSION['role_id'] != 3) {
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
    <title>Student Dashboard</title>
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container">
        <h2>Student Dashboard</h2>
        <p>Welcome, Student!</p>
        <ul>
            <li><a href="../staff/meal_planning.php">View Meal Plan</a></li>
            <li><a href="billing.php">View Billing</a></li>
        </ul>
    </div>
    <?php include('../includes/footer.php'); ?>
</body>
</html>
