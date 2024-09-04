<?php
include('includes/db.php');
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role_id = $_POST['role_id'];

    $sql = "INSERT INTO users (name, email, password, role_id) VALUES ('$name', '$email', '$password', '$role_id')";

    if ($conn->query($sql) === TRUE) {
        header("location: login.php");
    } else {
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>Register</title>
</head>
<body>
    <?php include('includes/header.php'); ?>
    <div class="container">
        <h2>Register</h2>
        <?php if ($error_message): ?>
            <div class="message error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <label for="name">Name</label>
            <input type="text" name="name" required>
            <label for="email">Email</label>
            <input type="email" name="email" required>
            <label for="password">Password</label>
            <input type="password" name="password" required>
            <label for="role">Role</label>
            <select name="role_id">
                <option value="1">Admin</option>
                <option value="2">Staff</option>
                <option value="3">Student</option>
            </select>
            <input type="submit" value="Register">
        </form>
    </div>
    <?php include('includes/footer.php'); ?>
</body>
</html>
