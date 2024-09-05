<?php
session_start();
if ($_SESSION['role_id'] != 1) {
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
    <title>Admin Dashboard</title>
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <p>Welcome, Admin!</p>
        <ul>
            <li><a href="../staff/inventory.php">Manage Inventory</a></li>
            <li><a href="../staff/meal_planning.php">Meal Planning</a></li>
            <li><a href="../student/billing.php">Billing</a></li>
            <li><a href="manage_users.php">Manage Users</a></li> <!-- New link added -->
        </ul>
    </div>
    <?php include('../includes/footer.php'); ?>
</body>
</html>
