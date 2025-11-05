<?php
// admin/logout.php

// Start session first
session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to home page
echo "<script>window.location.href = '../index.html';</script>";
exit;
?>