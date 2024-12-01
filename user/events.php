

<?php

include('../includes/header_user.php');
include('../includes/dbconnect.php');

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
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <style>
        /* Styling for the events page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .event-card {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin: 0 auto;
            justify-content: center;
        }
        .event {
            width: 300px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
        }
        .event img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        .event h3 {
            margin: 15px 0;
            font-size: 18px;
            color: #444;
        }
        .event p {
            font-size: 14px;
            color: #666;
            margin: 0 10px 15px;
        }
        .event a {
            display: inline-block;
            margin: 10px 0 15px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .event a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <h1>All Events</h1>
        <div class="event-card">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="event">';
                    echo '<h3>' . $row['name'] . '</h3>';
                    echo '<p>' . $row['description'] . '</p>';
                    echo '<a href="../show_event.php?id=' . $row['event_id'] . '">View Details</a>';
                    echo '</div>';
                }
            } else {
                echo '<p>No events found!</p>';
            }
            ?>
        </div>
    </div>
    
</body>
</html>
