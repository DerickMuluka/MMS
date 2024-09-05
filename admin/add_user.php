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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role_id = $_POST['role_id'];

    // Validate inputs
    if (empty($username) || empty($email) || empty($password) || empty($role_id)) {
        $error_message = "All fields are required.";
    } else {
        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into database
        $sql = "INSERT INTO users (username, email, password, role_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $username, $email, $hashed_password, $role_id);

        if ($stmt->execute()) {
            $success_message = "User added successfully.";
        } else {
            $error_message = "Error adding user: " . $conn->error;
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
    <title>Add User</title>
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container">
        <h2>Add New User</h2>

        <?php if ($error_message): ?>
            <div class="message error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <div class="message success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form method="POST" action="add_user.php">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="role_id">Role:</label>
                <select id="role_id" name="role_id" required>
                    <option value="">Select Role</option>
                    <?php while ($row = $roles_result->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['role_name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" class="btn">Add User</button>
        </form>
    </div>
    <?php include('../includes/footer.php'); ?>
</body>
</html>
