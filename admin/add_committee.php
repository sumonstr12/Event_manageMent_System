<?php
include('../includes/header_admin.php');
include('../includes/dbconnect.php');

// Check if the admin is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch all advisors
$advisors = $conn->query("SELECT advisor_id, name FROM advisors")->fetch_all(MYSQLI_ASSOC);

// Fetch all segments with event details
$segments = $conn->query("SELECT s.segment_id, s.name AS segment_name, e.name AS event_name, e.event_id 
                          FROM segments s
                          INNER JOIN events e ON s.event_id = e.event_id")->fetch_all(MYSQLI_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $department = trim($_POST['department']);
    $advisor_id = intval($_POST['advisor_id']);
    $segment_id = intval($_POST['segment_id']);

    // Fetch the associated event_id for the selected segment
    $segment_query = $conn->prepare("SELECT event_id FROM segments WHERE segment_id = ?");
    $segment_query->bind_param("i", $segment_id);
    $segment_query->execute();
    $segment_result = $segment_query->get_result();
    $segment_data = $segment_result->fetch_assoc();
    $event_id = $segment_data['event_id'] ?? null;

    // Validate required fields
    if (!empty($name) && !empty($email) && !empty($department) && $advisor_id && $segment_id && $event_id) {
        $stmt = $conn->prepare("INSERT INTO committees (name, email, department, advisor_id, segment_id, event_id) 
                               VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiis", $name, $email, $department, $advisor_id, $segment_id, $event_id);
        if ($stmt->execute()) {
            $success_message = "Committee member added successfully!";
        } else {
            $error_message = "Failed to add committee member. Please try again.";
        }
        $stmt->close();
    } else {
        $error_message = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Committee Member</title>
    <link rel="stylesheet" href="../assets/css/add_committee.css">
</head>
<body>
    <div class="container">
        <h1>Add Committee Member</h1>

        <!-- Success or Error Messages -->
        <?php if (!empty($success_message)): ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if (!empty($error_message)): ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Add Committee Member Form -->
        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="department">Department</label>
                <input type="text" id="department" name="department" required>
            </div>
            <div class="form-group">
                <label for="advisor_id">Advisor</label>
                <select id="advisor_id" name="advisor_id" required>
                    <option value="">Select an Advisor</option>
                    <?php foreach ($advisors as $advisor): ?>
                        <option value="<?php echo $advisor['advisor_id']; ?>">
                            <?php echo htmlspecialchars($advisor['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="segment_id">Segment</label>
                <select id="segment_id" name="segment_id" required>
                    <option value="">Select a Segment</option>
                    <?php foreach ($segments as $segment): ?>
                        <option value="<?php echo $segment['segment_id']; ?>">
                            <?php echo htmlspecialchars($segment['segment_name'] . " (" . $segment['event_name'] . ")"); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn">Add Committee Member</button>
        </form>
    </div>
</body>
</html>
