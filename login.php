<?php
include('includes/db.php');
session_start();

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE name='$name'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role_id'] = $row['role_id'];

            switch ($row['role_id']) {
                case 1:
                    header("location: admin/admin_dashboard.php");
                    break;
                case 2:
                    header("location: staff/staff_dashboard.php");
                    break;
                case 3:
                    header("location: student/student_dashboard.php");
                    break;
                default:
                    $error_message = "Invalid role.";
                    break;
            }
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "No user found with this name.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>Login</title>
</head>
<body>
    <?php include('includes/header.php'); ?>
    <div class="container">
        <h2>Login</h2>
        <?php if ($error_message): ?>
            <div class="message error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <label for="name">Name</label>
            <input type="text" name="name" required>
            <label for="password">Password</label>
            <input type="password" name="password" required>
            <input type="submit" value="Login">
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
    <?php include('includes/footer.php'); ?>
</body>
</html>
