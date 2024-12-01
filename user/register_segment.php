
<?php
include('../includes/dbconnect.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['segment_id'])) {
    $segment_id = intval($_GET['segment_id']);
    $user_id = $_SESSION['user_id'];

    // Check if the user already registered
    $stmt = $conn->prepare("SELECT * FROM registrations WHERE user_id = ? AND segment_id = ?");
    $stmt->bind_param("ii", $user_id, $segment_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        die("You are already registered for this segment.");
    }

    // Register the user
    $stmt = $conn->prepare("INSERT INTO registrations (user_id, segment_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $segment_id);

    if ($stmt->execute()) {
        echo "Successfully registered!";
    } else {
        echo "Registration failed.";
    }
} else {
    die("Invalid segment ID.");
}
?>
