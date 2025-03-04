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

// Fetch requests from the database
$query = "SELECT * FROM requests";
$result = $conn->query($query);

if (!$result) {
    die("Query Failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <table>
            <tr>
                <th>User ID</th>
                <th>Document Type</th>
                <th>Purpose</th>
                <th>Status</th>
                <th>Request Date</th>
                <th>Action</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['document_type']); ?></td>
                    <td><?php echo htmlspecialchars($row['purpose']); ?></td>
                    <td><?php echo ucfirst(htmlspecialchars($row['status'])); ?></td>
                    <td><?php echo htmlspecialchars($row['request_date']); ?></td>
                    <td>
                        <a href="update_status.php?id=<?php echo $row['id']; ?>&status=approved">Approve</a>
                        <a href="update_status.php?id=<?php echo $row['id']; ?>&status=rejected">Reject</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
