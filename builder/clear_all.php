<?php
require_once 'functions/builder.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log the request with timestamp
error_log("=== CLEAR ALL REQUEST STARTED ===");
error_log("Time: " . date('Y-m-d H:i:s'));
error_log("Request Method: " . $_SERVER['REQUEST_METHOD']);
error_log("Session ID: " . session_id());
error_log("Initial build data: " . print_r(getBuildData(), true));

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        error_log("Starting clearBuildSession()...");
        // Clear the build session
        clearBuildSession();
        
        // Verify the data is cleared
        $build_data = getBuildData();
        error_log("After first clear attempt - Build data: " . print_r($build_data, true));
        
        if (!empty($build_data)) {
            error_log("WARNING: Build data not empty after first clear! Attempting second clear...");
            // Try one more time
            clearBuildSession();
            $build_data = getBuildData();
            error_log("After second clear attempt - Build data: " . print_r($build_data, true));
        }
        
        error_log("=== CLEAR ALL REQUEST COMPLETED ===");
        
        // Return success response with redirect URL
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => true,
            'data' => $build_data,
            'redirect' => 'build.php'
        ]);
    } catch (Exception $e) {
        error_log("ERROR in clear_all.php: " . $e->getMessage());
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Internal server error']);
    }
} else {
    // If not a POST request, return error
    error_log("Invalid request method: " . $_SERVER['REQUEST_METHOD']);
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?> 