


<?php

include('../includes/header_admin.php');
include('../includes/dbconnect.php');

// Check if the admin is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch admin-specific details (optional)
$email = $_SESSION['email'];
$sql = "SELECT * FROM admins WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .welcome {
            text-align: center;
            margin-bottom: 30px;
        }
        .dashboard-links {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .card {
            width: 250px;
            padding: 20px;
            background: #007bff;
            color: white;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .card:hover {
            background-color: #0056b3;
        }
        .card h3 {
            margin: 10px 0;
            font-size: 18px;
        }
        .logout {
            text-align: center;
            margin-top: 30px;
        }
        .logout a {
            color: #fff;
            background-color: #dc3545;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout a:hover {
            background-color: #a71d2a;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <h1>Admin Dashboard</h1>
        <div class="welcome">
            <p>Welcome, <strong><?php echo htmlspecialchars($admin['name']); ?></strong>!</p>
            <p>Manage the event system efficiently using the tools below:</p>
        </div>
        <div class="dashboard-links">
            <a href="manage_clubs.php" class="card">
                <h3>Manage Clubs</h3>
            </a>
            <a href="manage_events.php" class="card">
                <h3>Manage Events</h3>
            </a>
            <a href="view_event.php" class="card">
                <h3>View Event</h3>
            </a>
            <!-- <a href="reports.php" class="card">
                <h3>Reports</h3>
            </a> -->
            <a href="sponsor.php" class="card">
                <h3>Sponsor</h3>
            </a>
        </div>
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
