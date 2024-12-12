<?php

include('../includes/header_n.php');
include('../includes/dbconnect.php');

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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Event Details</h1>
        <h2 class="text-2xl font-semibold text-gray-700 mb-2"><?php echo htmlspecialchars($event['name']); ?></h2>
        <p class="mb-2"><strong class="font-semibold text-gray-600">Description:</strong> <?php echo htmlspecialchars($event['description']); ?></p>
        <p class="mb-2"><strong class="font-semibold text-gray-600">Start Date:</strong> <?php echo $event['start_date']; ?></p>
        <p class="mb-2"><strong class="font-semibold text-gray-600">End Date:</strong> <?php echo $event['end_date']; ?></p>
        <p class="mb-2"><strong class="font-semibold text-gray-600">Club:</strong> <?php echo $event['club_name'] ?? 'N/A'; ?></p>
        <p class="mb-2"><strong class="font-semibold text-gray-600">Department:</strong> <?php echo $event['department_name'] ?? 'N/A'; ?></p>
        <p class="mb-4"><strong class="font-semibold text-gray-600">Admin:</strong> <?php echo $event['admin_email']; ?></p>

        <h2 class="text-xl font-semibold text-gray-700 mb-4">Event Segments</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php if (!empty($segments)): ?>
                <?php foreach ($segments as $segment): ?>
                    <div class="bg-gray-50 border border-gray-200 p-4 rounded-lg shadow-sm">
                        <h3 class="text-lg font-bold text-gray-800 mb-2"><?php echo htmlspecialchars($segment['name']); ?></h3>
                        <p class="text-gray-600 mb-2">Fee: <?php echo htmlspecialchars($segment['segment_fee']); ?></p>
                        <p class="text-gray-600 mb-4">
                            <?php echo htmlspecialchars(substr($segment['description'], 0, 100)); ?>
                            <?php if (strlen($segment['description']) > 100): ?>
                                ... <span class="text-blue-500 cursor-pointer underline read-more" data-full-text="<?php echo htmlspecialchars($segment['description']); ?>">Read More</span>
                            <?php endif; ?>
                        </p>
                        <div class="text-center">
                            <a href="user/login.php" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Register</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-600">No segments found for this event.</p>
            <?php endif; ?>
        </div>

        <div class="mt-6">
            <a href="events.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back to Events</a>
        </div>
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
