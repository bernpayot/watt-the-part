<?php
require_once __DIR__ . '/../config.php';

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
    // Clear the build session
    unset($_SESSION['build']);
    $_SESSION['build'] = [];
    
    // Force session write
    session_write_close();
    session_start();
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
                    
                    setJsonHeader();
                    echo json_encode([
                        'success' => true,
                        'message' => 'Component removed successfully',
                        'total' => $total
                    ]);
                    exit;
                }
            }
            
            http_response_code(400);
            setJsonHeader();
            echo json_encode([
                'success' => false,
                'message' => 'Invalid component type or component not found'
            ]);
            break;
            
        case 'clear':
            // Handle clear all
            clearBuildSession();
            setJsonHeader();
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
                
                setJsonHeader();
                echo json_encode([
                    'success' => true,
                    'data' => $build_data,
                    'total' => $total
                ]);
                exit;
            }
            
            http_response_code(400);
            setJsonHeader();
            echo json_encode([
                'success' => false,
                'message' => 'Invalid component data'
            ]);
            break;
            
        default:
            http_response_code(400);
            setJsonHeader();
            echo json_encode([
                'success' => false,
                'message' => 'Invalid action'
            ]);
    }
    exit;
}
?>