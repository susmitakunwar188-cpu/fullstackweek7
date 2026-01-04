<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'] ?? '';
    $full_name  = $_POST['name'] ?? '';
    $password   = $_POST['password'] ?? '';

    if (!empty($student_id) && !empty($full_name) && !empty($password)) {

        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        try {
            $sql = "INSERT INTO students (student_id, full_name, password_hash) 
                    VALUES (:student_id, :full_name, :password_hash)";
            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':student_id'    => $student_id,
                ':full_name'     => $full_name,
                ':password_hash' => $password_hash
            ]);

            header("Location: login.php");
            exit;

        } catch (PDOException $e) {
            $message = "Error inserting data: " . $e->getMessage();
        }

    } else {
        $message = "Please fill all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
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
        h1 {
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
        <h1>Register</h1>

        <?php if (!empty($message)) : ?>
            <p style="color:red;"><?php echo $message; ?></p>
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
            <label for="name">Full Name:</label>
            <input
              type="text"
              id="name"
              name="name"
              placeholder="Enter your full name"
              required
            >
          </div>

          <div>
            <label for="password">Password:</label>
            <input
              type="password"
              id="password"
              name="password"
              placeholder="Enter a password"
              required
            >
          </div>

          <div>
            <button type="submit">Register</button>
          </div>
        </form>

        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
