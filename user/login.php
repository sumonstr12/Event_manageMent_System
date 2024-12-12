<?php

include('../includes/dbconnect.php');
include('../includes/header_user.php');

$error_message = ""; // To display errors to the user

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        // Prepare statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];

            // Verify hashed password
            if (password_verify($password, $hashed_password)) {
                // Set session variables for logged-in user
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['email'] = $email;

                // Redirect to user dashboard
                header("Location: user_dashboard.php");
                exit();
            } else {
                $error_message = "Invalid password. Please try again.";
            }
        } else {
            $error_message = "No account found with this email.";
        }
        $stmt->close();
    } else {
        $error_message = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/users/login.css">
    <title>User Login</title>
</head>
<body>
    <div class="login-container">
        <h1>User Login</h1>
        <?php if (!empty($error_message)): ?>
            <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        <p>Don't have an account? <a href="user/register.php">Register here</a>.</p>
    </div>
</body>
</html>
