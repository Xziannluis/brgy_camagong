<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $document_type = $_POST['document_type'];
    $purpose = $_POST['purpose'];

    $stmt = $conn->prepare("INSERT INTO requests (user_id, document_type, purpose) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $document_type, $purpose);
    if ($stmt->execute()) {
        echo "<script>alert('Request submitted successfully!'); window.location.href='my_requests.php';</script>";
    } else {
        echo "<script>alert('Error submitting request.'); window.location.href='request_document.php';</script>";
    }
}
?>