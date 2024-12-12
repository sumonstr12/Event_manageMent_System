<?php

include('../includes/header_admin.php');
include('../includes/dbconnect.php');

// Check if the admin is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
        }
        .options {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .option {
            width: 150px;
            padding: 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .option:hover {
            background-color: #0056b3;
        }
        .option h3 {
            margin: 0;
            font-size: 18px;
        }
        .option p {
            margin-top: 10px;
            font-size: 14px;
            color: #f0f0f0;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <h1>Reports</h1>
        <div class="options">
            <!-- Link to Income Page -->
            <a href="income.php" class="option">
                <h3>Income</h3>
                <p>View total income generated for a selected event and its segments.</p>
            </a>

            <!-- Link to Expenditure Page -->
            <a href="expenditure.php" class="option">
                <h3>Expenditure</h3>
                <p>Log and review expenditure details for an event, categorized by segments.</p>
            </a>
        </div>
    </div>
</body>
</html>
