<?php
$servername = "localhost";  // or the hostname of your database
$username = "root";         // your database username
$password = "";             // your database password
$dbname = "brgy_camagong";  // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
