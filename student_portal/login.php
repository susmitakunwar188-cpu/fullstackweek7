<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'] ?? '';
    $password   = $_POST['password'] ?? '';

    if (!empty($student_id) && !empty($password)) {

        try {
            $sql  = "SELECT password_hash FROM students WHERE student_id = :student_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':student_id' => $student_id]);

            $row = $stmt->fetch();

            if ($row) {
                $stored_hash = $row['password_hash'];

                if (password_verify($password, $stored_hash)) {
                    $_SESSION['logged_in'] = true;
                    header("Location: dashboard.php");
                    exit;
                } else {
                    $error = "Invalid password.";
                }
            } else {
                $error = "Student ID not found.";
            }

        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
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
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }
        .container {
            max-width: 400px;
            margin: 60px auto;
            background: #fff;
            padding: 24px;
            border-radius: 6px;
            box-shadow: 0 0 6px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 16px;
        }
        label {
            display: block;
            margin-bottom: 4px;
            font-size: 1rem;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            font-size: 1rem;
        }
        button {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            cursor: pointer;
        }
        p {
            font-size: 0.95rem;
        }
    </style>
</head>
<body>
    <div class="container">
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
    </div>
</body>
</html>
