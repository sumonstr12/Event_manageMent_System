


<?php
// Include database connection
include('../includes/dbconnect.php');

// Check if 'segment_id' is provided
if (isset($_GET['segment_id'])) {
    $segment_id = intval($_GET['segment_id']); // Get the segment ID and sanitize

    // Query to fetch segment details
    $query = "SELECT * FROM segments WHERE segment_id = ?";
    $stmt = $conn->prepare($query); // Use prepared statements to prevent SQL injection
    $stmt->bind_param("i", $segment_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if segment exists
    if ($result->num_rows > 0) {
        $segment = $result->fetch_assoc(); // Fetch segment details
    } else {
        echo "<h2>Segment not found.</h2>";
        exit();
    }
} else {
    echo "<h2>No segment selected.</h2>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($segment['name']); ?> - Segment Details</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Header Styles */
        header {
            background: #007bff;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        header h1 {
            margin: 0;
        }

        /* Main Content Styles */
        main {
            padding: 20px;
            max-width: 800px;
            margin: 20px auto;
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Section Styles */
        section {
            margin-bottom: 20px;
        }

        section h2 {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        /* Paragraph Styles */
        p {
            font-size: 16px;
            margin: 10px 0;
        }

        /* Strong Text Styles */
        strong {
            color: #007bff;
        }

        /* Link Styles */
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
        }

        a:hover {
            background: #0056b3;
        }

        /* Footer Styles */
        footer {
            text-align: center;
            padding: 10px 0;
            background: #f4f4f4;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        footer p {
            margin: 0;
            color: #333;
        }
    </style>
</head>
<body>
    <header>
        <h1><?php echo htmlspecialchars($segment['name']); ?></h1>
    </header>

    <main>
        <section>
            <h2>Segment Details</h2>
            <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($segment['description'])); ?></p>
            
            <p><strong>Fee:</strong> <?php echo htmlspecialchars($segment['segment_fee']); ?> Tk</p>
        </section>

        <a href="show_event.php?id=<?php echo htmlspecialchars($segment['event_id']); ?>">Back to Segments</a>
    </main>

</body>
</html>
