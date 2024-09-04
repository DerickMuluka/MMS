<?php
session_start();
include('../includes/db.php');

if ($_SESSION['role_id'] != 1 && $_SESSION['role_id'] != 2) {
    header("location: ../login.php");
    exit;
}

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $meal_name = $_POST['meal_name'];
    $day_of_week = $_POST['day_of_week'];
    $time_of_day = $_POST['time_of_day'];

    $sql = "INSERT INTO meals (meal_name, day_of_week, time_of_day) VALUES ('$meal_name', '$day_of_week', '$time_of_day')";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Meal added successfully.";
    } else {
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$meals_sql = "SELECT * FROM meals";
$meals_result = $conn->query($meals_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>Meal Planning</title>
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container">
        <h2>Meal Planning</h2>
        <?php if ($error_message): ?>
            <div class="message error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if (isset($success_message)): ?>
            <div class="message success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <label for="meal_name">Meal Name</label>
            <input type="text" name="meal_name" required>
            <label for="day_of_week">Day of the Week</label>
            <select name="day_of_week">
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
            </select>
            <label for="time_of_day">Time of Day</label>
            <select name="time_of_day">
                <option value="Breakfast">Breakfast</option>
                <option value="Lunch">Lunch</option>
                <option value="Dinner">Dinner</option>
            </select>
            <input type="submit" value="Add Meal">
        </form>

        <h3>Meal Plan</h3>
        <table>
            <tr>
                <th>Meal Name</th>
                <th>Day of the Week</th>
                <th>Time of Day</th>
            </tr>
            <?php if ($meals_result->num_rows > 0): ?>
                <?php while($row = $meals_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['meal_name']; ?></td>
                        <td><?php echo $row['day_of_week']; ?></td>
                        <td><?php echo $row['time_of_day']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No meals planned.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
    <?php include('../includes/footer.php'); ?>
</body>
</html>
