

<?php

// this log in only for User. Admins are not included in this log in page
include('../includes/dbconnect.php');
include('../includes/header_admin.php');

$error_message = "";

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user 
    $stmt = $conn->prepare("SELECT password FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Verify the hashed password
        if (password_verify($password, $hashed_password)) {
            echo "Login successful!";
            $_SESSION['email'] = $email;
            header("Location: ../admin/dashboard.php");
            exit;
        } else {
            echo "Invalid password.";
        }
    } else {  
            $error_message = "Invalid email or password.";
    }
    $stmt->close();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/login.css">
    <title>Login</title>
</head>
<body>
    <div class="login-container">
        <h1>Admin_Login</h1>
        <?php if (!empty($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
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
        <p>Don't have an account? <a href="../user/register.php">Register here</a>.</p>
    </div>
</body>
</html>
