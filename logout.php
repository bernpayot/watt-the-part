<?php
require_once 'functions/auth.php';

if (isset($_POST['logout'])) {
    $result = $auth->logout();
    
    if ($result['success']) {
        header("Location: index.php");
        exit();
    }
}

// If someone tries to access this file directly without POST request
header("Location: index.php");
exit();
?> 