<?php
session_start();
include('db_connect.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];

// Query to retrieve the user's document requests
$sql = "SELECT document_type, purpose, status, request_date FROM requests WHERE user_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(['error' => 'Failed to prepare statement: ' . $conn->error]);
    exit();
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    echo json_encode(['error' => 'Failed to execute query: ' . $conn->error]);
    exit();
}

$requests = [];
while ($row = $result->fetch_assoc()) {
    // Format the request_date
    $formatted_date = date('F j, Y, g:i a', strtotime($row['request_date']));
    $row['request_date'] = $formatted_date;  // Add formatted date to the row
    $requests[] = $row;
}

echo json_encode($requests);

$stmt->close();
$conn->close();
?>
