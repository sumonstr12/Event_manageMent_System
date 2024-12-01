

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
    $dept_name = trim($_POST['dept_name']);
    $total_member = intval($_POST['total_member']);
    $dept_code = trim($_POST['dept_code']);

    if (!empty($dept_name) && !empty($dept_code) && $total_member > 0) {
        $stmt = $conn->prepare("INSERT INTO departments (dept_id, name, total_student) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $dept_code, $dept_name, $total_member);
        if ($stmt->execute()) {
            $success_message = "Department added successfully!";
        } else {
            $error_message = "Failed to add Department. Please try again.";
        }
        $stmt->close();
    } else {
        $error_message = "All fields are required, and total members must be a positive number.";
    }
}

// Fetch all clubs
$depts = [];
$result = $conn->query("SELECT * FROM departments");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $depts[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Departments</title>
    <link rel="stylesheet" href="../assets/css/add_club.css">
    <style>
        /* CSS styles remain the same */
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Departments</h1>
        <?php if (!empty($success_message)): ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if (!empty($error_message)): ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="club_name">Department Name</label>
                <input type="text" id="dept_name" name="dept_name" required>
            </div>
            <div class="form-group">
                <label for="total_member">Total Student</label>
                <input type="number" id="total_member" name="total_member" min="1" required>
            </div>
            <div class="form-group">
                <label for="dept_code">Dept Code</label>
                <input type="text" id="dept_code" name="dept_code" required>
            <button type="submit" class="btn">Add Club</button>
        </form>

        <h2>Existing Department</h2>
        <table>
            <thead>
                <tr>
                    <th>Department Name</th>
                    <th>Total Student</th>
                    <th>Dept Code</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($depts)): ?>
                    <?php foreach ($depts as $club): ?>
                        <tr>
                            
                            <td><?php echo htmlspecialchars($club['name']); ?></td>
                            <td><?php echo $club['total_student']; ?></td>
                            <td><?php echo $club['dept_id']; ?></td>
                            <td>
                                <a href="delete_dept.php?id=<?php echo $club['dept_id']; ?>" class="delete-btn">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No departments found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
