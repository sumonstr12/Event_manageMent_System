<?php
session_start();
include '../includes/dbconnect.php';

header('Content-Type: application/json');

// Decode the incoming JSON data
$data = json_decode(file_get_contents("php://input"), true);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($data['segment_id'], $data['regi_fee'])) {
    $segment_id = intval($data['segment_id']);
    $regi_fee = intval($data['regi_fee']);
    $registration_date = date('Y-m-d'); // Current date

    // Validate the segment ID
    $stmt = $conn->prepare("SELECT event_id FROM segments WHERE segment_id = ?");
    $stmt->bind_param("i", $segment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        echo json_encode(['success' => false, 'message' => 'Invalid segment ID.']);
        exit;
    }

    $event_id = $row['event_id'];

    // Check if the user is already registered for this segment
    $stmt = $conn->prepare("SELECT * FROM registrations WHERE user_id = ? AND segment_id = ?");
    $stmt->bind_param("ii", $user_id, $segment_id);
    $stmt->execute();
    $existing_registration = $stmt->get_result();

    if ($existing_registration->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'You are already registered for this segment.']);
        exit;
    }

    // Insert into registrations table
    $stmt = $conn->prepare("INSERT INTO registrations (user_id, segment_id, regi_fee, registration_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $user_id, $segment_id, $regi_fee, $registration_date);

    if ($stmt->execute()) {
        $regi_id = $stmt->insert_id; // Get the inserted registration ID

        // Insert into income table if the fee is greater than 0
        if ($regi_fee > 0) {
            $description = "Registration Fee";
            $stmt = $conn->prepare("INSERT INTO income (segment_id, event_id, amount, description, regi_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iiisi", $segment_id, $event_id, $regi_fee, $description, $regi_id);

            if (!$stmt->execute()) {
                echo json_encode(['success' => false, 'message' => 'Failed to record income: ' . $stmt->error]);
                exit;
            }
        }

        // Registration successful
        echo json_encode(['success' => true, 'message' => 'Registration successful!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to register: ' . $stmt->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing required data.']);
}
?>
