<?php
session_start();
require 'db.php'; // uses the same $conn as in register.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Read form values
    $student_id = $_POST['student_id'] ?? '';
    $password   = $_POST['password'] ?? '';

    if (!empty($student_id) && !empty($password)) {

        // 2. Prepare SELECT to get student row
        $sql = "SELECT password FROM students WHERE student_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $student_id);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows === 1) {
                // There is a student with this ID
                $stmt->bind_result($stored_hash);
                $stmt->fetch();

                // 3. Verify password
                if (password_verify($password, $stored_hash)) {
                    // 4. Set session and redirect
                    $_SESSION['logged_in'] = true;
                    header("Location: dashboard.php");
                    exit;
                } else {
                    $error = "Invalid password.";
                }
            } else {
                $error = "Student ID not found.";
            }

            $stmt->close();
        } else {
            $error = "Failed to prepare statement.";
        }
    } else {
        $error = "Please fill all fields.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Login</title>
</head>
<body>
    <h2>Login</h2>

    <?php if (!empty($error)) : ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="" method="post">
        <div>
            <label for="student_id">Student ID:</label>
            <input
                type="text"
                id="student_id"
                name="student_id"
                placeholder="Enter your student ID"
                required
            >
        </div>

        <div>
            <label for="password">Password:</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter your password"
                required
            >
        </div>

        <div>
            <button type="submit">Login</button>
        </div>
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>
