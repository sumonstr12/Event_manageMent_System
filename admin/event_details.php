<?php

include('../includes/header_admin.php');
include('../includes/dbconnect.php');

// Check if the admin is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

// Validate and fetch event ID
if (isset($_GET['id'])) {
    $event_id = intval($_GET['id']);
} else {
    die("Invalid request. Event ID is required.");
}

// Fetch event details
$stmt = $conn->prepare("SELECT e.*, 
                               c.name AS club_name, 
                               d.name AS department_name, 
                               a.email AS admin_email
                        FROM events e
                        LEFT JOIN clubs c ON e.club_id = c.club_id
                        LEFT JOIN departments d ON e.dept_id = d.dept_id
                        LEFT JOIN admins a ON e.admin_id = a.admin_id
                        WHERE e.event_id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Event not found.");
}
$event = $result->fetch_assoc();

// Fetch segments associated with this event
$segments = [];
$result = $conn->query("SELECT * FROM segments WHERE event_id = $event_id");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $segments[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link rel="stylesheet" href="../assets/css/event_details.css">
</head>
<body>
    <div class="container">
        <h1>Event Details</h1>
        <h2><?php echo htmlspecialchars($event['name']); ?></h2>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($event['description']); ?></p>
        <p><strong>Start Date:</strong> <?php echo $event['start_date']; ?></p>
        <p><strong>End Date:</strong> <?php echo $event['end_date']; ?></p>
        <p><strong>Club:</strong> <?php echo $event['club_name'] ?? 'N/A'; ?></p>
        <p><strong>Department:</strong> <?php echo $event['department_name'] ?? 'N/A'; ?></p>
        <p><strong>Admin:</strong> <?php echo $event['admin_email']; ?></p>
        <p><a href="add_segment.php?event_id=<?php echo $event_id; ?>" class="btn add-btn">Add Segment</a></p>

        <h2>Event Segments</h2>
        <div class="segments">
            <?php if (!empty($segments)): ?>
                <?php foreach ($segments as $segment): ?>
                    <div class="segment-card">
                        <h3><?php echo htmlspecialchars($segment['name']); ?></h3>
                        <p><?php echo htmlspecialchars($segment['segment_fee']); ?></p>
                        <p class="description-short">
                            <?php echo htmlspecialchars(substr($segment['description'], 0, 100)); ?>
                            <?php if (strlen($segment['description']) > 100): ?>
                                ... <span class="read-more" data-full-text="<?php echo htmlspecialchars($segment['description']); ?>">Read More</span>
                            <?php endif; ?>
                        </p>
                        <div class="actions">
                            <a href="add_committee.php?segment_id=<?php echo $segment['segment_id']; ?>" class="btn">Add Committee</a>
                            <a href="view_members.php" class="btn">View Members</a>
                            <a href="add_advisor.php?segment_id=<?php echo $segment['segment_id']; ?>" class="btn">Add Advisor</a>
                            
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No segments found for this event.</p>
            <?php endif; ?>
        </div>

        <a href="view_event.php" class="btn back-btn">Back to Events</a>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll('.read-more').forEach(span => {
                span.addEventListener('click', () => {
                    const fullText = span.getAttribute('data-full-text');
                    span.parentElement.innerHTML = fullText;
                });
            });
        });
    </script>
</body>
</html>
