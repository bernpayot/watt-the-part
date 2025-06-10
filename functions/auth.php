<?php
require_once __DIR__ . '/../dbconn.php';
session_start();

class Auth {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function login($email, $password) {
        if (empty($email) || empty($password)) {
            return ['success' => false, 'message' => 'All fields are required.'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Invalid email format!'];
        }

        $stmt = $this->conn->prepare("SELECT user_id, username, password FROM users WHERE email = ?");
        if (!$stmt) {
            return ['success' => false, 'message' => 'Database error occurred.'];
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['logged_in'] = true;
                $stmt->close();
                return ['success' => true, 'message' => 'Login successful!'];
            }
            $stmt->close();
            return ['success' => false, 'message' => 'Invalid password.'];
        }
        
        $stmt->close();
        return ['success' => false, 'message' => 'User not found.'];
    }

    public function register($username, $email, $password) {
        if (empty($username) || empty($email) || empty($password)) {
            return ['success' => false, 'message' => 'All fields are required.'];
        }

        $stmt = $this->conn->prepare("SELECT user_id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            return ['success' => false, 'message' => 'Username already exists.'];
        }

        $stmt = $this->conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            return ['success' => false, 'message' => 'Email already registered.'];
        }

        $hash_pw = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hash_pw);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Account successfully created.'];
        }
        
        return ['success' => false, 'message' => 'Something went wrong during registration.'];
    }

    public function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    public function getCurrentUser() {
        if ($this->isLoggedIn()) {
            return [
                'user_id' => $_SESSION['user_id'],
                'username' => $_SESSION['username']
            ];
        }
        return null;
    }

    public function logout() {
        session_unset();
        session_destroy();
        return ['success' => true, 'message' => 'Logged out successfully.'];
    }

    public function requireLogin() {
        if (!$this->isLoggedIn()) {
            header('Location: login.php');
            exit();
        }
    }
}

$auth = new Auth($conn);
?> 