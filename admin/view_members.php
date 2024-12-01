<?php
include('../includes/header_admin.php');
include('../includes/dbconnect.php');

// Check if the admin is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch all advisors grouped by segments
$advisors = [];
$result = $conn->query("SELECT a.*, s.name AS segment_name 
                        FROM advisors a
                        LEFT JOIN segments s ON a.segment_id = s.segment_id");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $advisors[$row['segment_name']][] = $row;
    }
}

// Fetch all committees grouped by segments
$committees = [];
$result = $conn->query("SELECT c.*, s.name AS segment_name 
                        FROM committees c
                        LEFT JOIN segments s ON c.segment_id = s.segment_id");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $committees[$row['segment_name']][] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Members</title>
    <link rel="stylesheet" href="../assets/css/view_members.css">
</head>
<body>
    <div class="container">
        <h1>View Members</h1>

        <!-- Advisors Section -->
        <div class="card">
            <h2>Advisors</h2>
            <?php if (!empty($advisors)): ?>
                <?php foreach ($advisors as $segment_name => $advisor_group): ?>
                    <h3>Segment: <?php echo htmlspecialchars($segment_name); ?></h3>
                    <ul>
                        <?php foreach ($advisor_group as $advisor): ?>
                            <li>
                                <strong>Name:</strong> <?php echo htmlspecialchars($advisor['name']); ?><br>
                                <strong>Email:</strong> <?php echo htmlspecialchars($advisor['email']); ?><br>
                                <strong>Department:</strong> <?php echo htmlspecialchars($advisor['department']); ?>
                            </li>
                            <hr>
                        <?php endforeach; ?>
                    </ul>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No advisors found.</p>
            <?php endif; ?>
        </div>

        <!-- Committees Section -->
        <div class="card">
            <h2>Committees</h2>
            <?php if (!empty($committees)): ?>
                <?php foreach ($committees as $segment_name => $committee_group): ?>
                    <h3>Segment: <?php echo htmlspecialchars($segment_name); ?></h3>
                    <ul>
                        <?php foreach ($committee_group as $committee): ?>
                            <li>
                                <strong>Name:</strong> <?php echo htmlspecialchars($committee['name']); ?><br>
                                <strong>Email:</strong> <?php echo htmlspecialchars($committee['email']); ?><br>
                                <strong>Discipline:</strong> <?php echo htmlspecialchars($committee['department']); ?><br>
                                <strong>Segment:</strong> <?php echo htmlspecialchars($segment_name); ?>
                            </li>
                            <hr>
                        <?php endforeach; ?>
                    </ul>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No committees found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
