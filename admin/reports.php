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
    </style>
</head>
<body>
    
    <div class="container">
        <h1>Reports</h1>
        <div class="options">
            <a href="income.php" class="option">
                <h3>Income</h3>
            </a>
            <a href="expenditure.php" class="option">
                <h3>expenditure</h3>
            </a>
        </div>
    </div>
</body>
</html>

