<?php
// Start the session
session_start();

// Include database connection
include('db_connect.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the request ID and status are provided
if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    // Update the request status in the database
    $stmt = $conn->prepare("UPDATE requests SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    
    if ($stmt->execute()) {
        // Redirect back to the admin dashboard after updating
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // Handle any errors if the query fails
        die("Error updating status: " . $conn->error);
    }
} else {
    // Handle cases where id or status is not provided
    die("Invalid request.");
}

// Close database connection
$conn->close();
?>
