<?php
include('../includes/header_admin.php');
include('../includes/dbconnect.php');

// Check if admin is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

// Initialize variables
$success_message = "";
$error_message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_id = intval($_POST['event_id']);
    $sponsor_name = trim($_POST['sponsor_name']);
    $amount = floatval($_POST['amount']);
    $description = trim($_POST['description']);

    if (!empty($event_id) && !empty($sponsor_name) && !empty($description)) {
        // Insert sponsorship record
        $stmt = $conn->prepare("INSERT INTO sponsorships (event_id, sponsor_name, amount) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $event_id, $sponsor_name, $amount);

        if ($stmt->execute()) {
            $sponsor_id = $conn->insert_id; // Get the inserted sponsor_id

            // Insert into income table
            $stmt_income = $conn->prepare("INSERT INTO income (segment_id, event_id, amount, description, sponsor_id) VALUES (NULL, ?, ?, ?, ?)");
            $stmt_income->bind_param("iisi", $event_id, $amount, $description, $sponsor_id);

            if ($stmt_income->execute()) {
                $success_message = "Sponsorship and income record added successfully!";
            } else {
                $error_message = "Failed to add income record: " . $conn->error;
            }
            $stmt_income->close();
        } else {
            $error_message = "Failed to add sponsorship: " . $conn->error;
        }
        $stmt->close();
    } else {
        $error_message = "Please fill out all fields correctly.";
    }
}

// Fetch sponsorship details
$sponsorships = [];
$result = $conn->query("SELECT s.sponsor_id, e.name AS event_name, s.sponsor_name, s.amount 
                        FROM sponsorships s
                        JOIN events e ON s.event_id = e.event_id");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sponsorships[] = $row;
    }
}

// Fetch all events for the dropdown
$events = [];
$result = $conn->query("SELECT event_id, name FROM events");
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
    <link rel="stylesheet" href="../assets/css/sponsor.css">
    <title>Sponsorship Management</title>
</head>
<body>
    <div class="container">
        <h1>Sponsorship Management</h1>

        <?php if (!empty($success_message)): ?>
            <p class="success-message"><?php echo htmlspecialchars($success_message); ?></p>
        <?php endif; ?>

        <?php if (!empty($error_message)): ?>
            <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <!-- Sponsorship Form -->
        <form action="sponsor.php" method="POST" class="sponsor-form">
            <div class="form-group">
                <label for="event_id">Select Event:</label>
                <select name="event_id" id="event_id" required>
                    <option value="">-- Select an Event --</option>
                    <?php foreach ($events as $event): ?>
                        <option value="<?php echo $event['event_id']; ?>">
                            <?php echo htmlspecialchars($event['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="sponsor_name">Sponsor Name:</label>
                <input type="text" id="sponsor_name" name="sponsor_name" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn">Add Sponsorship</button>
        </form>

        <!-- Sponsorship Details -->
        <h2>Existing Sponsorships</h2>
        <?php if (!empty($sponsorships)): ?>
            <table class="sponsorship-table">
                <thead>
                    <tr>
                        <th>Sponsor ID</th>
                        <th>Event Name</th>
                        <th>Sponsor Name</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sponsorships as $sponsorship): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($sponsorship['sponsor_id']); ?></td>
                            <td><?php echo htmlspecialchars($sponsorship['event_name']); ?></td>
                            <td><?php echo htmlspecialchars($sponsorship['sponsor_name']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($sponsorship['amount'], 2)); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No sponsorships found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
