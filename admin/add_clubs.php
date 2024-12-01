<?php
include('../includes/header_admin.php');
include('../includes/dbconnect.php');

// Check if the admin is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

// Handle form submission for adding a club
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $club_name = trim($_POST['club_name']);
    $club_type = trim($_POST['club_type']);
    $total_member = intval($_POST['total_member']);

    if (!empty($club_name) && !empty($club_type) && $total_member > 0) {
        $stmt = $conn->prepare("INSERT INTO clubs (name, total_member, club_type) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $club_name, $total_member, $club_type);
        if ($stmt->execute()) {
            $success_message = "Club added successfully!";
        } else {
            $error_message = "Failed to add club. Please try again.";
        }
        $stmt->close();
    } else {
        $error_message = "All fields are required, and total members must be a positive number.";
    }
}

// Fetch all clubs
$clubs = [];
$result = $conn->query("SELECT * FROM clubs");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $clubs[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Clubs</title>
    <link rel="stylesheet" href="../assets/css/add_club.css">
    <style>
        /* CSS styles remain the same */
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Clubs</h1>
        <?php if (!empty($success_message)): ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if (!empty($error_message)): ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="club_name">Club Name</label>
                <input type="text" id="club_name" name="club_name" required>
            </div>
            <div class="form-group">
                <label for="club_type">Club Type</label>
                <input type="text" id="club_type" name="club_type" required>
            </div>
            <div class="form-group">
                <label for="total_member">Total Members</label>
                <input type="number" id="total_member" name="total_member" min="1" required>
            </div>
            <button type="submit" class="btn">Add Club</button>
        </form>

        <h2>Existing Clubs</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Club Name</th>
                    <th>Total Members</th>
                    <th>Club Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($clubs)): ?>
                    <?php foreach ($clubs as $club): ?>
                        <tr>
                            <td><?php echo $club['club_id']; ?></td>
                            <td><?php echo htmlspecialchars($club['name']); ?></td>
                            <td><?php echo $club['total_member']; ?></td>
                            <td><?php echo htmlspecialchars($club['club_type']); ?></td>
                            <td>
                                <a href="delete_club.php?id=<?php echo $club['club_id']; ?>" class="delete-btn">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No clubs found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
