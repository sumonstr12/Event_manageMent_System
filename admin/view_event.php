

<?php

include('../includes/header_admin.php');
include('../includes/dbconnect.php');

// Check if the admin is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch all events
$events = [];
$result = $conn->query("SELECT e.*, 
                               c.name AS club_name, 
                               d.name AS department_name, 
                               a.email AS admin_email
                        FROM events e
                        LEFT JOIN clubs c ON e.club_id = c.club_id
                        LEFT JOIN departments d ON e.dept_id = d.dept_id
                        LEFT JOIN admins a ON e.admin_id = a.admin_id");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Events</title>
    <link rel="stylesheet" href="../assets/css/view_event.css">
</head>
<body>
    <div class="container">
        <h1>All Events</h1>
        <table>
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Description</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Club</th>
                    <th>Department</th>
                    <th>Admin</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($events)): ?>
                    <?php foreach ($events as $event): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($event['name']); ?></td>
                            <td><?php echo htmlspecialchars($event['description']); ?></td>
                            <td><?php echo $event['start_date']; ?></td>
                            <td><?php echo $event['end_date']; ?></td>
                            <td><?php echo $event['club_name'] ?? 'N/A'; ?></td>
                            <td><?php echo $event['department_name'] ?? 'N/A'; ?></td>
                            <td><?php echo $event['admin_email']; ?></td>
                            <td>
                                <a href="event_details.php?id=<?php echo $event['event_id']; ?>" class="details-btn">View Details</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9">No events found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
