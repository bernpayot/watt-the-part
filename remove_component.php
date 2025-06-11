<?php
require_once 'functions/builder.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log the request
error_log("=== REMOVE COMPONENT REQUEST ===");
error_log("Request Method: " . $_SERVER['REQUEST_METHOD']);
error_log("Session ID: " . session_id());
error_log("POST data: " . print_r($_POST, true));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the component type from POST data
    $component_type = isset($_POST['component']) ? $_POST['component'] : null;
    
    if ($component_type) {
        // Get current build data
        $build_data = getBuildData();
        
        // Log before removal
        error_log("Before removal - Component type: " . $component_type);
        error_log("Current build data: " . print_r($build_data, true));
        
        // Remove the component if it exists
        if (isset($build_data[$component_type])) {
            unset($build_data[$component_type]);
            setBuildData($build_data);
            
            // Log after removal
            error_log("After removal - Build data: " . print_r($build_data, true));
            
            // Calculate new total
            $total = calculateTotal($build_data);
            
            // Return success response
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Component removed successfully',
                'total' => $total
            ]);
            exit;
        }
    }
    
    // If we get here, something went wrong
    header('HTTP/1.1 400 Bad Request');
    echo json_encode([
        'success' => false,
        'message' => 'Invalid component type or component not found',
        'debug' => [
            'component_type' => $component_type,
            'post_data' => $_POST
        ]
    ]);
    exit;
}

// If not POST request
header('HTTP/1.1 405 Method Not Allowed');
echo json_encode([
    'success' => false,
    'message' => 'Only POST requests are allowed'
]);
exit;
?> 