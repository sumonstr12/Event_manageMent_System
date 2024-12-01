

<?php
include('../includes/header_admin.php');
include('../includes/dbconnect.php');

// Check if the admin is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

// Validate and fetch event ID
if (isset($_GET['event_id'])) {
    $event_id = intval($_GET['event_id']);
} else {
    die("Invalid request. Event ID is required.");
}

// Fetch event details
$stmt = $conn->prepare("SELECT name FROM events WHERE event_id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Event not found.");
}
$event = $result->fetch_assoc();

// Handle form submission
$success_message = "";
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $segment_type = trim($_POST['segment_type']);
    $segment_fee = intval($_POST['segment_fee']);

    // Validate form inputs
    if (empty($name) || empty($description) || empty($segment_type)) {
        $error_message = "All fields are required.";
    } else {
        // Insert segment into the database
        $stmt = $conn->prepare("INSERT INTO segments (name, event_id, description, segment_type, segment_fee) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sissi", $name, $event_id, $description, $segment_type, $segment_fee);

        if ($stmt->execute()) {
            $success_message = "Segment added successfully!";
        } else {
            $error_message = "Failed to add segment. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Segment</title>
    <link rel="stylesheet" href="../assets/css/add_segment.css">
</head>
<body>
    <div class="container">
        <h1>Add Segment</h1>
        <p>Adding a segment for the event: <strong><?php echo htmlspecialchars($event['name']); ?></strong></p>

        <?php if (!empty($success_message)): ?>
            <p class="success"><?php echo $success_message; ?></p>
        <?php endif; ?>
        
        <?php if (!empty($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="name">Segment Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="description">Segment Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="segment_type">Segment Type:</label>
                <select id="segment_type" name="segment_type" required>
                    <option value="">Select Type</option>
                    <option value="Workshop">Workshop</option>
                    <option value="Competition">Competition</option>
                    <option value="Seminar">Seminar</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="segment_fee">Segment Fee:</label>
                <textarea id="segment_fee" name="segment_fee" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn">Add Segment</button>
        </form>

        <a href="event_details.php?id=<?php echo $event_id; ?>" class="btn back-btn">Back to Event Details</a>
    </div>
</body>
</html>
