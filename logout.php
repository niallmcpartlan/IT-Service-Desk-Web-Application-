<?php
session_start();      // Start the session so we can clear it
session_unset();      // Remove all session variables
session_destroy();    // Destroy the session completely
header("Location: login.php");  // Redirect user back to login page
exit;                 // Stop script execution
?>