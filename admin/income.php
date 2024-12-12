<?php
include('../includes/header_admin.php');
include('../includes/dbconnect.php');

// Check if the admin is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch all events for the dropdown
$query = "SELECT event_id, name FROM events";
$result = mysqli_query($conn, $query);
$events = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = $row;
    }
}

// Handle form submission
$totalIncome = 0;
$segmentDetails = [];
$sponsorshipDetails = [];
$registrationIncome = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $eventId = intval($_POST['event_id']);

    // Fetch segment-wise income
    $incomeQuery = "SELECT s.name AS segment_name, SUM(i.amount) AS total 
                    FROM income i
                    JOIN segments s ON i.segment_id = s.segment_id
                    WHERE i.event_id = ?
                    GROUP BY i.segment_id";

    $stmt = $conn->prepare($incomeQuery);

    if ($stmt === false) {
        die("SQL Error: " . $conn->error); // Log SQL error and terminate script
    }

    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $segmentDetails[] = $row;
            $totalIncome += $row['total'];
        }
    } else {
        die("Execution Error: " . $stmt->error); // Log execution error
    }

    // Fetch sponsorship income
    $sponsorshipQuery = "SELECT sponsor_name, amount 
                         FROM sponsorship 
                         WHERE event_id = ?";
    $stmt = $conn->prepare($sponsorshipQuery);

    if ($stmt === false) {
        die("SQL Error: " . $conn->error);
    }

    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $sponsorshipDetails[] = $row;
            $totalIncome += $row['amount'];
        }
    }

    // Fetch registration income
    $registrationQuery = "SELECT SUM(segment_fee) AS total 
                          FROM segments 
                          WHERE event_id = ?";
    $stmt = $conn->prepare($registrationQuery);

    if ($stmt === false) {
        die("SQL Error: " . $conn->error);
    }

    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        $registrationIncome = $row['total'];
        $totalIncome += $registrationIncome;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income Report</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            margin-bottom: 30px;
            text-align: center;
        }
        select, button {
            padding: 10px;
            margin: 10px 5px;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Income Report</h1>

        <!-- Event Selection Form -->
        <form method="POST" action="income.php">
            <label for="event_id">Select Event:</label>
            <select name="event_id" id="event_id" required>
                <option value="">-- Select an Event --</option>
                <?php foreach ($events as $event): ?>
                    <option value="<?= $event['event_id']; ?>"><?= htmlspecialchars($event['name']); ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">View Income</button>
        </form>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <h2>Total Income: $<?= number_format($totalIncome, 2); ?></h2>

            <!-- Segment Income -->
            <h3>Segment Income</h3>
            <table>
                <thead>
                    <tr>
                        <th>Segment</th>
                        <th>Income ($)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($segmentDetails as $detail): ?>
                        <tr>
                            <td><?= htmlspecialchars($detail['segment_name']); ?></td>
                            <td><?= number_format($detail['total'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Sponsorship Income -->
            <h3>Sponsorship Income</h3>
            <table>
                <thead>
                    <tr>
                        <th>Sponsor</th>
                        <th>Amount ($)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sponsorshipDetails as $detail): ?>
                        <tr>
                            <td><?= htmlspecialchars($detail['sponsor_name']); ?></td>
                            <td><?= number_format($detail['amount'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Registration Income -->
            <h3>Registration Income</h3>
            <p>$<?= number_format($registrationIncome, 2); ?></p>

        <?php endif; ?>
    </div>
</body>
</html>
