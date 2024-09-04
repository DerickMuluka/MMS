<?php
session_start();
include('../includes/db.php');

// Ensure only students can access this page
if ($_SESSION['role_id'] != 3) {
    header("location: ../login.php");
    exit;
}

// Fetch all orders and their billing status for the logged-in user
$orders_sql = "SELECT orders.id, inventory.item_name, orders.quantity, orders.total_price, billing.billing_date, billing.status 
FROM orders 
JOIN inventory ON orders.item_id = inventory.id 
LEFT JOIN billing ON orders.billing_id = billing.id
WHERE orders.user_id = {$_SESSION['user_id']}";
$orders_result = $conn->query($orders_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>Billing</title>
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container">
        <h2>Billing Information</h2>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Billing Date</th>
                <th>Status</th>
            </tr>
            <?php if ($orders_result->num_rows > 0): ?>
                <?php while ($row = $orders_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['item_name']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td><?php echo $row['total_price']; ?></td>
                        <td><?php echo $row['billing_date'] ? $row['billing_date'] : 'Pending'; ?></td>
                        <td><?php echo $row['status'] ? $row['status'] : 'Unbilled'; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No billing records found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
    <?php include('../includes/footer.php'); ?>
</body>
</html>
