
<?php
session_start(); // Start the session

// Destroy all session variables
session_unset();

// Destroy the session itself
session_destroy();

// Redirect the user to the homepage (or login page)
header("Location: ../index.php");
exit();
?>
