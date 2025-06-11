<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize build session if it doesn't exist
if (!isset($_SESSION['build'])) {
    $_SESSION['build'] = [];
}

function getBuildData() {
    return isset($_SESSION['build']) ? $_SESSION['build'] : [];
}

function setBuildData($data) {
    $_SESSION['build'] = $data;
}

function clearBuildSession() {
    error_log("=== CLEARING BUILD SESSION ===");
    error_log("Session ID before clearing: " . session_id());
    error_log("Current build data before clearing: " . print_r($_SESSION['build'], true));
    
    // First unset the build session
    unset($_SESSION['build']);
    error_log("After unset - Session build data: " . print_r($_SESSION['build'] ?? 'null', true));
    
    // Then reinitialize as empty array
    $_SESSION['build'] = [];
    error_log("After reinitialization - Session build data: " . print_r($_SESSION['build'], true));
    
    // Force session write
    session_write_close();
    session_start();
    
    error_log("Session ID after restart: " . session_id());
    error_log("Final build data after clearing: " . print_r($_SESSION['build'], true));
    error_log("=== BUILD SESSION CLEARED ===");
}
?> 