<?php
session_start();
include('../includes/db.php');

// Ensure only students can access this page
if ($_SESSION['role_id'] != 3) {
    header("location: ../login.php");
    exit;
}

// Fetch all items from inventory
$items_sql = "SELECT * FROM inventory";
$items_result = $conn->query($items_sql);

// Handle order submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    $order_date = date('Y-m-d');

    // Fetch item price
    $item_sql = "SELECT unit_price FROM inventory WHERE id = $item_id";
    $item_result = $conn->query($item_sql);
    $item = $item_result->fetch_assoc();
    $total_price = $item['unit_price'] * $quantity;

    // Insert order into orders table
    $insert_order_sql = "INSERT INTO orders (user_id, item_id, quantity, order_date, total_price) VALUES 
    ({$_SESSION['user_id']}, $item_id, $quantity, '$order_date', $total_price)";
    if ($conn->query($insert_order_sql) === TRUE) {
        echo "<div class='message success-message'>Order placed successfully!</div>";
    } else {
        echo "<div class='message error-message'>Error placing order: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>View Items</title>
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container">
        <h2>Available Items</h2>
        <table>
            <tr>
                <th>Item Name</th>
                <th>Quantity Available</th>
                <th>Unit Price</th>
                <th>Order</th>
            </tr>
            <?php if ($items_result->num_rows > 0): ?>
                <?php while ($row = $items_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['item_name']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td><?php echo $row['unit_price']; ?></td>
                        <td>
                            <form action="" method="POST">
                                <input type="hidden" name="item_id" value="<?php echo $row['id']; ?>">
                                <input type="number" name="quantity" min="1" max="<?php echo $row['quantity']; ?>" required>
                                <input type="submit" value="Order" class="btn">
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No items available.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
    <?php include('../includes/footer.php'); ?>
</body>
</html>
