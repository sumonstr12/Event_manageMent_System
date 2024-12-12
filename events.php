<?php

include('includes/header_n.php');
include('includes/dbconnect.php');

// Fetch events from the database
$sql = "SELECT * FROM events";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Events</title>
    <link href="event.css" rel="stylesheet">
    <link href="Tailwind/output.css" rel="stylesheet">
    <script>
        // Dark mode toggle
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
        }
    </script>
</head>
<body class="bg-red-500 dark:bg-gray-900 text-gray-800 dark:text-red-500">

    <div class="container mx-auto px-6 py-12 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-4xl font-bold text-center">All Events</h1>
            <button 
                onclick="toggleDarkMode()" 
                class="bg-blue-500 dark:bg-blue-dark text-white py-2 px-4 rounded hover:bg-red-600 dark:hover:bg-red-700">
                Toggle Dark Mode
            </button>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="event bg-red-600 border border-gray-600 dark:border-gray-600 rounded-lg  p-6 text-center">';
                    echo '<h3 class="text-2xl font-semibold mb-4">' . htmlspecialchars($row['name']) . '</h3>';
                    echo '<p class="mb-6">' . htmlspecialchars($row['description']) . '</p>';
                    echo '<a href="view_details.php?id=' . $row['event_id'] . '" class="bg-red-500 dark:bg-red-dark text-black py-2 px-4 rounded hover:bg-blue-600 dark:hover:bg-blue-700">View Details</a>';
                    echo '</div>';
                }
            } else {
                echo '<p class="text-center">No events found!</p>';
            }
            ?>
        </div>
    </div>
    
</body>
</html>
