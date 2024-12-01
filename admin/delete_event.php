<?php
session_start();
include('../includes/dbconnect.php');

// Check if the admin is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

// Check if the event ID is provided in the query string
if (isset($_GET['id'])) {
    $event_id = intval($_GET['id']);

    // Prepare the delete query
    $stmt = $conn->prepare("DELETE FROM events WHERE event_id = ?");
    $stmt->bind_param("i", $event_id);

    if ($stmt->execute()) {
        // If successful, redirect back to the events management page with a success message
        $_SESSION['message'] = "Event deleted successfully!";
        $_SESSION['message_type'] = "success";
        echo "Event deleted successfully!";
    } else {
        // If failed, redirect back with an error message
        $_SESSION['message'] = "Failed to delete the event. Please try again.";
        $_SESSION['message_type'] = "error";
    }

    $stmt->close();
} else {
    $_SESSION['message'] = "Invalid request. Event ID is missing.";
    $_SESSION['message_type'] = "error";
}

// Redirect back to the manage events page
header("Location: manage_events.php");
exit();
?>
