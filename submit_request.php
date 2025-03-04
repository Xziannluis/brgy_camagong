<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $document = $_POST['document'];  // Using 'document' to match form field name
    $purpose = $_POST['purpose'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("INSERT INTO requests (user_id, document_type, purpose) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $document, $purpose);

    if ($stmt->execute()) {
        // After successful submission, redirect to 'my_request.html'
        echo "<script>alert('Request submitted successfully!'); window.location.href='my_request.html';</script>";
    } else {
        // If something goes wrong, show an error message
        echo "<script>alert('Error submitting request. Please try again.'); window.location.href='request_document.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
