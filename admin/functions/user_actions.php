<?php
require_once '../../dbconn.php';

function updateUser($user_id, $username, $email, $role_id) {
    global $conn;
    
    $query = "UPDATE users SET username = ?, email = ?, role_id = ? WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssii", $username, $email, $role_id, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        return ['success' => true, 'message' => 'User updated successfully'];
    } else {
        return ['success' => false, 'message' => 'Failed to update user'];
    }
}

function deleteUser($user_id) {
    global $conn;
    
    // First check if user exists
    $check_query = "SELECT user_id FROM users WHERE user_id = ?";
    $check_stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($check_stmt, "i", $user_id);
    mysqli_stmt_execute($check_stmt);
    $result = mysqli_stmt_get_result($check_stmt);
    
    if (mysqli_num_rows($result) === 0) {
        return ['success' => false, 'message' => 'User not found'];
    }
    
    // Delete user
    $query = "DELETE FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        return ['success' => true, 'message' => 'User deleted successfully'];
    } else {
        return ['success' => false, 'message' => 'Failed to delete user'];
    }
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $response = ['success' => false, 'message' => 'Invalid action'];
    
    switch ($action) {
        case 'update':
            if (isset($_POST['user_id'], $_POST['username'], $_POST['email'], $_POST['role_id'])) {
                $response = updateUser(
                    $_POST['user_id'],
                    $_POST['username'],
                    $_POST['email'],
                    $_POST['role_id']
                );
            }
            break;
            
        case 'delete':
            if (isset($_POST['user_id'])) {
                $response = deleteUser($_POST['user_id']);
            }
            break;
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?> 