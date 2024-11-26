<?php
$servername = "localhost"; 
$username = "6530182121";
$password = "1005";
$database = "6530182121";

// สร้าง connection
$conn = new mysqli($servername, $username, $password, $database);

// ตรวจสอบ connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully"; 
?>