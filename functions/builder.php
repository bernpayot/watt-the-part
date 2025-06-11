<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

function calculateTotal($build_data) {
    $total = 0;
    foreach ($build_data as $component) {
        $total += $component['price'];
    }
    return $total;
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    
    switch ($action) {
        case 'remove':
            // Handle component removal
            $component_type = isset($_POST['component']) ? $_POST['component'] : null;
            
            if ($component_type) {
                $build_data = getBuildData();
                
                if (isset($build_data[$component_type])) {
                    unset($build_data[$component_type]);
                    setBuildData($build_data);
                    $total = calculateTotal($build_data);
                    
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => true,
                        'message' => 'Component removed successfully',
                        'total' => $total
                    ]);
                    exit;
                }
            }
            
            header('HTTP/1.1 400 Bad Request');
            echo json_encode([
                'success' => false,
                'message' => 'Invalid component type or component not found'
            ]);
            break;
            
        case 'clear':
            // Handle clear all
            clearBuildSession();
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'All components cleared successfully'
            ]);
            break;
            
        case 'add':
            // Handle adding component
            $component_data = json_decode(file_get_contents('php://input'), true);
            
            if ($component_data) {
                $build_data = getBuildData();
                $build_data[$component_data['type']] = $component_data;
                setBuildData($build_data);
                $total = calculateTotal($build_data);
                
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'data' => $build_data,
                    'total' => $total
                ]);
                exit;
            }
            
            header('HTTP/1.1 400 Bad Request');
            echo json_encode([
                'success' => false,
                'message' => 'Invalid component data'
            ]);
            break;
            
        default:
            header('HTTP/1.1 400 Bad Request');
            echo json_encode([
                'success' => false,
                'message' => 'Invalid action'
            ]);
    }
    exit;
}
?>