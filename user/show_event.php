<?php
// Include database connection
include('../includes/header_user.php');
include('../includes/dbconnect.php'); // Replace with your actual database connection file

// Check if 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $event_id = intval($_GET['id']); // Get the event ID from the URL and sanitize it

    // Query to fetch event details
    $query = "SELECT * FROM events WHERE event_id = ?";
    $stmt = $conn->prepare($query); // Use prepared statements to prevent SQL injection
    $stmt->bind_param("i", $event_id); // Bind the event ID as an integer
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the event exists
    if ($result->num_rows > 0) {
        $event = $result->fetch_assoc(); // Fetch event details
    } else {
        echo "<h2>Event not found.</h2>";
        exit();
    }
} else {
    echo "<h2>No event selected.</h2>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($event['name']); ?> - Event Details</title>
    <link rel="stylesheet" href="../assets/css/users/show_event.css">
    <link rel="stylesheet" href="assets/css/footer.css">
</head>
<body>
    <header class="event-header">
        <h1 class="event-title"><?php echo htmlspecialchars($event['name']); ?></h1>
    </header>

    <main class="event-main">
        <section class="event-details">
            <h2 class="details-title">Event Details</h2>
            <p><strong>Start Date:</strong> <?php echo htmlspecialchars($event['start_date']); ?></p>
            <p><strong>End Date:</strong> <?php echo htmlspecialchars($event['end_date']); ?></p>
            <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
        </section>

        <section class="available-segments">
            <h2 class="segments-title">Available Segments</h2>
            <?php
            // Query to fetch segments associated with this event
            $segment_query = "SELECT * FROM segments WHERE event_id = ?";
            $segment_stmt = $conn->prepare($segment_query);
            $segment_stmt->bind_param("i", $event_id);
            $segment_stmt->execute();
            $segments = $segment_stmt->get_result();

            if ($segments->num_rows > 0) {
                echo "<ul class='segments-list'>";
                while ($segment = $segments->fetch_assoc()) {
                    echo "<li class='segment-item'><strong>" . htmlspecialchars($segment['name']) . "</strong> - ";
                    echo "<a class='readmore-link' href='segment_details.php?segment_id=" . $segment['segment_id'] . "'>Read More</a> | ";

                    // Add a link to register for the segment
                    echo "<a class='register-link' href='user/register_segment.php?segment_id=" . $segment['segment_id'] . "'>Register</a></li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No segments available for this event.</p>";
            }
            ?>
        </section>


        <a class="back-link" href="index.php">Back to Events</a>
    </main>

    
</body>
</html>