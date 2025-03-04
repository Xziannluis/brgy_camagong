<?php
session_start();
include('db_connect.php');

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You are not logged in.");
}

$user_id = $_SESSION['user_id'];

// Query to retrieve the user's document requests
$sql = "SELECT document_type, purpose, status, request_date FROM requests WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Display the results as HTML table rows
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['document_type']}</td>
            <td>{$row['purpose']}</td>
            <td>" . ucfirst($row['status']) . "</td>
            <td>{$row['request_date']}</td>
          </tr>";
}

$stmt->close();
$conn->close();
?>
