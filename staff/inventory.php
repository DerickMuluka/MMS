<?php
session_start();
include('../includes/db.php');

if ($_SESSION['role_id'] != 1 && $_SESSION['role_id'] != 2) {
    header("location: ../login.php");
    exit;
}

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];
    $unit_price = $_POST['unit_price'];

    $sql = "INSERT INTO inventory (item_name, quantity, unit_price) VALUES ('$item_name', '$quantity', '$unit_price')";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Item added successfully.";
    } else {
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$items_sql = "SELECT * FROM inventory";
$items_result = $conn->query($items_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>Manage Inventory</title>
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container">
        <h2>Manage Inventory</h2>
        <?php if ($error_message): ?>
            <div class="message error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if (isset($success_message)): ?>
            <div class="message success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <label for="item_name">Item Name</label>
            <input type="text" name="item_name" required>
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" required>
            <label for="unit_price">Unit Price</label>
            <input type="text" name="unit_price" required>
            <input type="submit" value="Add Item">
        </form>

        <h3>Inventory List</h3>
        <table>
            <tr>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Value</th>
            </tr>
            <?php if ($items_result->num_rows > 0): ?>
                <?php while($row = $items_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['item_name']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td><?php echo $row['unit_price']; ?></td>
                        <td><?php echo $row['quantity'] * $row['unit_price']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No items in inventory.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
    <?php include('../includes/footer.php'); ?>
</body>
</html>
