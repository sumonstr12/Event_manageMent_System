<?php
session_start();
include('dbconnect.php');

// Initialize variables for navbar items
$navbar_items = [];

// Check if the user is logged in
if (isset($_SESSION['email'])) {
    // User is logged in
    $navbar_items = [
        'Home' => 'user/user_dashboard.php',
        'Events' => 'events.php',
        'Segments' => 'user/segments.php',
        'Logout' => 'logout.php',
    ];
} else {
    // User is not logged in
    $navbar_items = [
        'Home' => 'index.php',
        'Events' => 'events.php',
        'Login' => 'user/login.php',
        'Register' => 'register.php',
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Tailwind/output.css">
    <title>Event Management System</title>
</head>
<body>
    <nav class="bg-gray-800 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <a href="#" class="text-white text-lg font-semibold">EVENT.HOLD</a>
            
            <!-- Navbar Links -->
            <div class="space-x-4">
                <?php foreach ($navbar_items as $name => $link): ?>
                    <a href="<?php echo $link; ?>" class="text-gray-300 hover:text-white">
                        <?php echo $name; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </nav>
</body>
</html>
