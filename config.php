<?php
// Error reporting configuration
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session configuration
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database configuration
require_once 'sensitiveStrings.php';

// Common functions
function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

// Common headers
function setJsonHeader() {
    header('Content-Type: application/json; charset=utf-8');
}
?> 