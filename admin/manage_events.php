<?php
include('../includes/header_admin.php');
include('../includes/dbconnect.php');

// Check if the admin is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

// Get the admin ID based on the logged-in email
$admin_email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT admin_id FROM admins WHERE email = ?");
$stmt->bind_param("s", $admin_email);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
$admin_id = $admin['admin_id'];
$stmt->close();

// Handle form submission for adding an event
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_name = trim($_POST['event_name']);
    $club_id = isset($_POST['club_id']) && $_POST['club_id'] !== 'none' ? intval($_POST['club_id']) : null;
    $dept_id = isset($_POST['dept_id']) && $_POST['dept_id'] !== 'none' ? intval($_POST['dept_id']) : null;
    $description = trim($_POST['description']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    if (!empty($event_name) && !empty($description) && !empty($start_date) && !empty($end_date) && ($club_id || $dept_id)) {
        // Ensure only one of club_id or dept_id is set
        if ($club_id && !$dept_id) {
            $dept_id = null;
        } elseif ($dept_id && !$club_id) {
            $club_id = null;
        }

        $stmt = $conn->prepare("INSERT INTO events (name, club_id, dept_id, description, start_date, end_date, admin_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siisssi", $event_name, $club_id, $dept_id, $description, $start_date, $end_date, $admin_id);
        if ($stmt->execute()) {
            $success_message = "Event added successfully!";
        } else {
            $error_message = "Failed to add event. Please try again.";
        }
        $stmt->close();
    } else {
        $error_message = "All fields are required, and either a club or department must be selected.";
    }
}

// Fetch all events
$events = [];
$result = $conn->query("SELECT e.*, 
                               c.name AS club_name, 
                               d.name AS department_name, 
                               a.email AS admin_email
                        FROM events e
                        LEFT JOIN clubs c ON e.club_id = c.club_id
                        LEFT JOIN departments d ON e.dept_id = d.dept_id
                        LEFT JOIN admins a ON e.admin_id = a.admin_id");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

// Fetch clubs and departments for the dropdown
$clubs = $conn->query("SELECT club_id, name FROM clubs")->fetch_all(MYSQLI_ASSOC);
$departments = $conn->query("SELECT dept_id, name FROM departments")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events</title>
    <link rel="stylesheet" href="../assets/css/add_event.css">
</head>
<body>
    <div class="container">
        <h1>Manage Events</h1>
        <?php if (!empty($success_message)): ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if (!empty($error_message)): ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Add Event Form -->
        <form action="" method="POST">
            <div class="form-group">
                <label for="event_name">Event Name</label>
                <input type="text" id="event_name" name="event_name" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="club_id">Club</label>
                <select id="club_id" name="club_id">
                    <option value="none">None</option>
                    <?php foreach ($clubs as $club): ?>
                        <option value="<?php echo $club['club_id']; ?>"><?php echo $club['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="dept_id">Department</label>
                <select id="dept_id" name="dept_id">
                    <option value="none">None</option>
                    <?php foreach ($departments as $department): ?>
                        <option value="<?php echo $department['dept_id']; ?>"><?php echo $department['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" id="end_date" name="end_date" required>
            </div>
            <button type="submit" class="btn">Add Event</button>
        </form>

        <!-- Display Existing Events -->
        <h2>Existing Events</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Event Name</th>
                    <th>Description</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Club</th>
                    <th>Department</th>
                    <th>Admin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($events)): ?>
                    <?php foreach ($events as $event): ?>
                        <tr>
                            <td><?php echo $event['event_id']; ?></td>
                            <td><?php echo htmlspecialchars($event['name']); ?></td>
                            <td><?php echo htmlspecialchars($event['description']); ?></td>
                            <td><?php echo $event['start_date']; ?></td>
                            <td><?php echo $event['end_date']; ?></td>
                            <td><?php echo $event['club_name'] ? $event['club_name'] : 'N/A'; ?></td>
                            <td><?php echo $event['department_name'] ? $event['department_name'] : 'N/A'; ?></td>
                            <td><?php echo $event['admin_email']; ?></td>
                            <td>
                                <a href="delete_event.php?id=<?php echo $event['event_id']; ?>" class="delete-btn">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9">No events found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const clubSelect = document.getElementById('club_id');
            const deptSelect = document.getElementById('dept_id');

            clubSelect.addEventListener('change', function () {
                if (clubSelect.value !== 'none') {
                    deptSelect.value = 'none';
                    deptSelect.disabled = true;
                } else {
                    deptSelect.disabled = false;
                }
            });

            deptSelect.addEventListener('change', function () {
                if (deptSelect.value !== 'none') {
                    clubSelect.value = 'none';
                    clubSelect.disabled = true;
                } else {
                    clubSelect.disabled = false;
                }
            });
        });
    </script>
</body>
</html>
