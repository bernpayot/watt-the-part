<?php
// Prevent any output before JSON response
error_reporting(E_ALL);
ini_set('display_errors', 0);

session_start();

// Debug session variables
$debug = [
    'session_id' => session_id(),
    'user_id' => $_SESSION['user_id'] ?? 'not set',
    'role_id' => $_SESSION['role_id'] ?? 'not set',
    'username' => $_SESSION['username'] ?? 'not set'
];

// Ensure database connection is working
try {
    require_once '../../dbconn.php';
    if (!isset($conn) || !$conn) {
        throw new Exception('Database connection failed');
    }
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Database connection error: ' . $e->getMessage()]);
    exit;
}

// Set JSON header
header('Content-Type: application/json');

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in', 'debug' => $debug]);
    exit;
}

// Verify admin role in database
$user_id = $_SESSION['user_id'];
$query = "SELECT role_id FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user || $user['role_id'] != 1) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access', 'debug' => $debug]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'create':
            try {
                // Validate and sanitize input
                $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
                $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
                $brand_id = filter_input(INPUT_POST, 'brand_id', FILTER_VALIDATE_INT);
                $ctype_id = filter_input(INPUT_POST, 'ctype_id', FILTER_VALIDATE_INT);

                // Debug input values
                $debug = [
                    'name' => $name,
                    'price' => $price,
                    'brand_id' => $brand_id,
                    'ctype_id' => $ctype_id
                ];

                if (!$name || $price === false || !$brand_id || !$ctype_id) {
                    throw new Exception('Invalid input data: ' . json_encode($debug));
                }

                // Insert new component into database
                $query = "INSERT INTO components (name, price, brand_id, ctype_id, component_img) VALUES (?, ?, ?, ?, '')";
                
                $stmt = mysqli_prepare($conn, $query);
                if (!$stmt) {
                    throw new Exception('Database prepare error: ' . mysqli_error($conn));
                }

                if (!mysqli_stmt_bind_param($stmt, "sdii", $name, $price, $brand_id, $ctype_id)) {
                    throw new Exception('Parameter binding error: ' . mysqli_stmt_error($stmt));
                }
                
                if (!mysqli_stmt_execute($stmt)) {
                    throw new Exception('Error creating component: ' . mysqli_stmt_error($stmt));
                }

                $component_id = mysqli_insert_id($conn);
                if (!$component_id) {
                    throw new Exception('Failed to get new component ID');
                }

                echo json_encode([
                    'success' => true, 
                    'message' => 'Component created successfully',
                    'component_id' => $component_id
                ]);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
            break;

        case 'update':
            try {
                // Validate and sanitize input
                $component_id = filter_input(INPUT_POST, 'component_id', FILTER_VALIDATE_INT);
                $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
                $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
                $brand_id = filter_input(INPUT_POST, 'brand_id', FILTER_VALIDATE_INT);
                $ctype_id = filter_input(INPUT_POST, 'ctype_id', FILTER_VALIDATE_INT);

                // Debug input values
                $debug = [
                    'component_id' => $component_id,
                    'name' => $name,
                    'price' => $price,
                    'brand_id' => $brand_id,
                    'ctype_id' => $ctype_id
                ];

                if (!$component_id || !$name || $price === false || !$brand_id || !$ctype_id) {
                    throw new Exception('Invalid input data: ' . json_encode($debug));
                }

                // Update component in database
                $query = "UPDATE components SET 
                         name = ?, 
                         price = ?, 
                         brand_id = ?, 
                         ctype_id = ? 
                         WHERE component_id = ?";
                
                $stmt = mysqli_prepare($conn, $query);
                if (!$stmt) {
                    throw new Exception('Database prepare error: ' . mysqli_error($conn));
                }

                if (!mysqli_stmt_bind_param($stmt, "sdiis", $name, $price, $brand_id, $ctype_id, $component_id)) {
                    throw new Exception('Parameter binding error: ' . mysqli_stmt_error($stmt));
                }
                
                if (!mysqli_stmt_execute($stmt)) {
                    throw new Exception('Error updating component: ' . mysqli_stmt_error($stmt));
                }

                if (mysqli_stmt_affected_rows($stmt) === 0) {
                    throw new Exception('No component was updated. Component ID may not exist.');
                }

                echo json_encode(['success' => true, 'message' => 'Component updated successfully']);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
            break;

        case 'delete':
            try {
                // Validate component ID
                $component_id = filter_input(INPUT_POST, 'component_id', FILTER_VALIDATE_INT);
                
                if (!$component_id) {
                    throw new Exception('Invalid component ID');
                }

                // Check if component exists before deleting
                $check_query = "SELECT component_id FROM components WHERE component_id = ?";
                $check_stmt = mysqli_prepare($conn, $check_query);
                if (!$check_stmt) {
                    throw new Exception('Database prepare error: ' . mysqli_error($conn));
                }

                mysqli_stmt_bind_param($check_stmt, "i", $component_id);
                mysqli_stmt_execute($check_stmt);
                $result = mysqli_stmt_get_result($check_stmt);

                if (mysqli_num_rows($result) === 0) {
                    throw new Exception('Component not found');
                }

                // Delete component from database
                $query = "DELETE FROM components WHERE component_id = ?";
                $stmt = mysqli_prepare($conn, $query);
                if (!$stmt) {
                    throw new Exception('Database prepare error: ' . mysqli_error($conn));
                }

                if (!mysqli_stmt_bind_param($stmt, "i", $component_id)) {
                    throw new Exception('Parameter binding error: ' . mysqli_stmt_error($stmt));
                }
                
                if (!mysqli_stmt_execute($stmt)) {
                    throw new Exception('Error deleting component: ' . mysqli_stmt_error($stmt));
                }

                if (mysqli_stmt_affected_rows($stmt) === 0) {
                    throw new Exception('No component was deleted');
                }

                echo json_encode(['success' => true, 'message' => 'Component deleted successfully']);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
            break;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?> 