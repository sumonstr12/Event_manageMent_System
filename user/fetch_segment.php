<?php
// Connect to database
include '../includes/dbconnect.php';

if (isset($_GET['segment_id'])) {
    $segmentId = intval($_GET['segment_id']);
    $query = "SELECT description, segment_type, segment_fee FROM segments WHERE segment_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $segmentId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode([
            'success' => true, 
            'description' => $row['description'], 
            'segment_type' => $row['segment_type'], 
            'segment_fee' => $row['segment_fee']
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Segment not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
