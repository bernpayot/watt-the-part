<?php
require_once 'functions/builder.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get the build data
$build_data = getBuildData();

// Calculate total
$total = 0;
foreach ($build_data as $component) {
    $total += $component['price'];
}

// Return the data as JSON
header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'success' => true,
    'data' => $build_data,
    'total' => $total
]);
?> 