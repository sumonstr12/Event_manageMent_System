
<?php
session_start();
include('dbconnect.php');

// Initialize variables for navbar items
$navbar_items = [];

// Check if the user is logged in
if (isset($_SESSION['email'])) {
    // User is logged in
    $navbar_items = [
        'Home' => 'user_dashboard.php',
        'Events' => 'events.php',
        'Logout' => 'logout.php',
    ];
} else {
    // User is not logged in
    $navbar_items = [
        'Home' => '../index.php',
        'Events' => 'events.php',
        'Login' => 'login.php',
        'Register' => 'register.php',
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Event Management System</title>
    <style>
        /* Navbar styling */
        nav {
            background-color: #333;
            padding: 10px 20px;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        nav ul li {
            margin: 0 10px;
        }
        nav ul li a {
            text-decoration: none;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
        }
        nav ul li a:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <?php foreach ($navbar_items as $name => $link): ?>
                <li><a href="<?php echo $link; ?>"><?php echo $name; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>
</body>
</html>
