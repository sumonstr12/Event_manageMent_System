

<?php
session_start();
include('dbconnect.php');

// Initialize variables for navbar
$navbar_items = [];

// Check if the user is logged in
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    $email = $_SESSION['email'];
    $password = $_SESSION['password']; // Assuming password is stored in session

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $user_result = $stmt->get_result();

        if ($user_result->num_rows > 0) {
            // Regular user is logged in
            $navbar_items = [
                'Home' => 'user/index.php',
                'Events' => 'events.php',
                'Segments' => 'user/segments.php',
                'Logout' => 'logout.php',
            ];
        }
    $stmt->close();
} else {
    // Not logged in
    $navbar_items = [
        'Home' => 'index.php',
        'Events' => 'events.php',
        'Login' => 'user/login.php',
        'Register' => 'user/register.php',
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

    <!-- Add a custom CSS file for the navbar -->
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
