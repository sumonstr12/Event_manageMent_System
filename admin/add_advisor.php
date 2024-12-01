

<?php
include('../includes/header_admin.php');
include('../includes/dbconnect.php');

// Check if the admin is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

// Validate and fetch segment ID
if (isset($_GET['segment_id'])) {
    $segment_id = intval($_GET['segment_id']);
} else {
    die("Invalid request. Segment ID is required.");
}

// Fetch segment details
$stmt = $conn->prepare("SELECT name FROM segments WHERE segment_id = ?");
$stmt->bind_param("i", $segment_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Segment not found.");
}
$segment = $result->fetch_assoc();

// Handle form submission
$success_message = "";
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $department = trim($_POST['department']);

    // Validate form inputs
    if (empty($name) || empty($email) || empty($department)) {
        $error_message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email address.";
    } else {
        // Insert advisor into the database
        $stmt = $conn->prepare("INSERT INTO advisors (name, email, department, segment_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $email, $department, $segment_id);

        if ($stmt->execute()) {
            $success_message = "Advisor added successfully!";
        } else {
            $error_message = "Failed to add advisor. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Advisor</title>
    <link rel="stylesheet" href="../assets/css/add_advisor.css">
</head>
<body>
    <div class="container">
        <h1>Add Advisor</h1>
        <p>Adding an advisor for the segment: <strong><?php echo htmlspecialchars($segment['name']); ?></strong></p>

        <?php if (!empty($success_message)): ?>
            <p class="success"><?php echo $success_message; ?></p>
        <?php endif; ?>

        <?php if (!empty($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="name">Advisor Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Advisor Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="department">Department:</label>
                <input type="text" id="department" name="department" required>
            </div>

            <button type="submit" class="btn">Add Advisor</button>
        </form>

        <a href="segment_details.php?id=<?php echo $segment_id; ?>" class="btn back-btn">Back to Segment Details</a>
    </div>
</body>
</html>
