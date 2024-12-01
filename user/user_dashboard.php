
<?php
include('../includes/header_user.php');
include('../includes/dbconnect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch all events with their segments
$events = [];
$stmt = $conn->prepare("
    SELECT e.event_id, e.name AS event_name, e.start_date, e.end_date, 
    s.segment_id, s.name AS segment_name, s.description, s.segment_fee 
    FROM events e
    LEFT JOIN segments s ON e.event_id = s.event_id
    ORDER BY e.start_date ASC

");
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $events[$row['event_id']]['event_name'] = $row['event_name'];
    $events[$row['event_id']]['start_date'] = $row['start_date'];
    $events[$row['event_id']]['end_date'] = $row['end_date'];
    $events[$row['event_id']]['segments'][] = [
        'segment_id' => $row['segment_id'],
        'name' => $row['segment_name'],
        'description' => $row['description'],
        'segment_fee' => $row['segment_fee']
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../assets/css/users/user_dashboard.css">
</head>
<body>
    <div class="container">
        <h1>Available Events</h1>

        <?php foreach ($events as $event_id => $event): ?>
            <div class="event-card">
                <h2><?php echo htmlspecialchars($event['event_name']); ?></h2>
                <p><strong>Start Date:</strong> <?php echo $event['start_date']; ?></p>
                <p><strong>End Date:</strong> <?php echo $event['end_date']; ?></p>
                <h3 class="av-seg">Available Segments:</h3>
                <div class="segments">
                    <?php foreach ($event['segments'] as $segment): ?>


                        <div class="segment-card">
                        <h3><?php echo htmlspecialchars($segment['name']); ?></h3>
                        <p>
                            <div class="container1">
                                <!-- Pass the segment ID dynamically -->
                                <button 
                                    class="infoButton btn1-register" 
                                    data-segment-id="<?php echo $segment['segment_id']; ?>">
                                    read more
                                </button>
                                


                                <!-- extra-portion -->
                                <button 
                                    class="btn-register" 
                                    data-segment-id="<?php echo $segment['segment_id']; ?>" 
                                    data-segment-name="<?php echo htmlspecialchars($segment['name']); ?>"
                                    data-segment-fee="<?php echo htmlspecialchars($segment['segment_fee']); ?>">
                                    Register
                                </button>


                            </div>
                        </p>
                    </div>

                    <!-- Modal (only one modal shared across segments) -->
                    <div id="infoModal" class="modal">
                        <div class="modal-content">
                            <span class="close-button">&times;</span>
                            <p id="modalDescription"></p>
                            <p id="modalSegmentType"></p>
                            <p id="modalSegmentFee"></p>

                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Modal Structure -->
    <div id="registerModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Register for: <span id="segmentName"></span></h3>
            <p>Fee: <span id="segmentFee"></span> tk</p>
            <button id="confirmRegister">Register</button>
            <button id="cancelRegister">Cancel</button>
        </div>
    </div>


    <script>

        document.addEventListener("DOMContentLoaded", function () {
        const infoButtons = document.querySelectorAll(".infoButton");
        const modal = document.getElementById("infoModal");
        const modalDescription = document.getElementById("modalDescription");
        const modalSegmentType = document.getElementById("modalSegmentType");
        const modalSegmentFee = document.getElementById("modalSegmentFee");
        const closeButton = document.querySelector(".close-button");

        if(modalSegmentFee == 0){
            modalSegmentFee.style.display = "free !";
        }

        // Event listener for all info buttons
        infoButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const segmentId = this.getAttribute("data-segment-id");

                // Fetch segment description using AJAX
                fetch(`fetch_segment.php?segment_id=${segmentId}`)
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        // Update modal content
                        modalDescription.innerHTML = `
                            <strong>Type:</strong> ${data.segment_type}<br>
                            <strong>Fee:</strong> ${data.segment_fee} <strong>tk</strong> <br>
                            <strong>Description:</strong> ${data.description}
                        `;
                        modal.style.display = "block"; // Show modal
                    } else {
                        alert(data.message || "Failed to fetch segment information.");
                    }
                })
                .catch((error) => {
                    console.error("Fetch Error:", error); // Log any fetch errors
                });

            });
        });

        // Close modal
        closeButton.addEventListener("click", function () {
            modal.style.display = "none";
        });

        // Close modal when clicking outside
        window.addEventListener("click", function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        });
    });

    </script>
    <script src="../assets/js/register_segment.js"></script>
</body>
</html>
