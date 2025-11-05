<?php
// includes/config.php

// Enable all errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Admin credentials - Change these in production environment
define('ADMIN_USERNAME', 'cos_hardware_admin');
define('ADMIN_PASSWORD', 'KnustSci@2024!Support');

// Simple session management
function startAdminSession() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

// Check if admin is logged in
function checkAdminAuth() {
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header('Location: login.php');
        exit;
    }
}

// Basic sanitization
function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}

// Validate admin credentials
function validateAdminCredentials($username, $password) {
    return $username === ADMIN_USERNAME && $password === ADMIN_PASSWORD;
}
?>