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

// Fetch user data
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $user_sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($user_sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user_result = $stmt->get_result();
    $user = $user_result->fetch_assoc();
} else {
    header("location: manage_users.php");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role_id = $_POST['role_id'];

    // Validate inputs
    if (empty($username) || empty($email) || empty($role_id)) {
        $error_message = "All fields are required.";
    } else {
        // Update user in the database
        $update_sql = "UPDATE users SET username = ?, email = ?, role_id = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("ssii", $username, $email, $role_id, $user_id);

        if ($stmt->execute()) {
            $success_message = "User updated successfully.";
        } else {
            $error_message = "Error updating user: " . $conn->error;
        }
    }
}

// Fetch all roles for the dropdown
$roles_sql = "SELECT * FROM roles";
$roles_result = $conn->query($roles_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>Edit User</title>
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container">
        <h2>Edit User</h2>

        <?php if ($error_message): ?>
            <div class="message error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <div class="message success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form method="POST" action="edit_user.php?id=<?php echo $user_id; ?>">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
            </div>

            <div class="form-group">
                <label for="role_id">Role:</label>
                <select id="role_id" name="role_id" required>
                    <option value="">Select Role</option>
                    <?php while ($row = $roles_result->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>" <?php echo $row['id'] == $user['role_id'] ? 'selected' : ''; ?>>
                            <?php echo $row['role_name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" class="btn">Update User</button>
        </form>
    </div>
    <?php include('../includes/footer.php'); ?>
</body>
</html>
