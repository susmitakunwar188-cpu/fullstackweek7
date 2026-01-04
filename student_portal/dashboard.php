<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$theme = 'light';
if (isset($_COOKIE['theme'])) {
    $theme = $_COOKIE['theme'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            <?php if ($theme === 'dark') : ?>
                background-color: #000;
                color: #fff;
            <?php else : ?>
                background-color: #f5f5f5;
                color: #000;
            <?php endif; ?>
        }
        .container {
            max-width: 500px;
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
        nav ul {
            list-style: none;
            padding: 0;
        }
        nav li {
            margin-bottom: 8px;
        }
        a {
            color: inherit;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, Student</h1>

        <p>Current theme: <?php echo htmlspecialchars($theme); ?></p>

        <nav>
            <ul>
                <li><a href="preference.php">Change Theme Preference</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</body>
</html>
