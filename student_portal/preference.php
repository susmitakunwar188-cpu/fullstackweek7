<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = $_POST['theme'] ?? 'light';
    setcookie('theme', $value, time() + 86400 * 30, "/");
    header("Location: dashboard.php");
    exit;
}

$current_theme = $_COOKIE['theme'] ?? 'light';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Theme Preference</title>
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
            font-size: 1rem;
        }
        button {
            margin-top: 12px;
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
        <h2>Choose Theme</h2>

        <form action="" method="post">
            <div>
                <label>
                    <input
                        type="radio"
                        name="theme"
                        value="light"
                        <?php if ($current_theme === 'light') echo 'checked'; ?>
                    >
                    Light Mode
                </label>
            </div>

            <div>
                <label>
                    <input
                        type="radio"
                        name="theme"
                        value="dark"
                        <?php if ($current_theme === 'dark') echo 'checked'; ?>
                    >
                    Dark Mode
                </label>
            </div>

            <button type="submit">Save Preference</button>
        </form>

        <p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>
