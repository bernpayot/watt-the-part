<?php
require_once 'functions/builder.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get the POST data
$component_data = json_decode(file_get_contents('php://input'), true);

if ($component_data) {
    // Get current build data
    $build_data = getBuildData();
    
    // Add the new component
    $build_data[$component_data['type']] = $component_data;
    
    // Save the updated build data
    setBuildData($build_data);
    
    // Calculate total
    $total = 0;
    foreach ($build_data as $component) {
        $total += $component['price'];
    }
    
    // Return success response
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => true,
        'data' => $build_data,
        'total' => $total
    ]);
} else {
    // Return error response
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid component data'
    ]);
}
?> 