
<?php
include('../includes/dbconnect.php');

if (isset($_GET['segment_id'])) {
    $segment_id = intval($_GET['segment_id']);

    $stmt = $conn->prepare("SELECT * FROM segments WHERE segment_id = ?");
    $stmt->bind_param("i", $segment_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(["error" => "Segment not found"]);
    }
} else {
    echo json_encode(["error" => "Segment ID is required"]);
}
?>
