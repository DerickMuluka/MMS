<?php
session_start();
include('../includes/db.php');

// Ensure only admin users can access this page
if ($_SESSION['role_id'] != 1) {
    header("location: ../login.php");
    exit;
}

$error_message = '';
$success_message = '';

// Handle user deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM users WHERE id = $delete_id";
    if ($conn->query($delete_sql) === TRUE) {
        $success_message = "User deleted successfully.";
    } else {
        $error_message = "Error deleting user: " . $conn->error;
    }
}

// Fetch all users
$users_sql = "SELECT users.id, users.username, users.email, roles.role_name FROM users JOIN roles ON users.role_id = roles.id";
$users_result = $conn->query($users_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>Manage Users</title>
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container">
        <h2>Manage Users</h2>

        <?php if ($error_message): ?>
            <div class="message error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <div class="message success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <a href="add_user.php" class="btn">Add New User</a>

        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            <?php if ($users_result->num_rows > 0): ?>
                <?php while ($row = $users_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['role_name']; ?></td>
                        <td>
                            <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn">Edit</a>
                            <a href="manage_users.php?delete_id=<?php echo $row['id']; ?>" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No users found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
    <?php include('../includes/footer.php'); ?>
</body>
</html>
