<?php
include 'connection.php';

// รับข้อมูลจากฟอร์ม
$fruit_id = $_POST['fruit_id'];
$fruit_name = $_POST['fruit_name'];
$price_per_unit = $_POST['price_per_unit'];
$unit = $_POST['unit'];
$stock = $_POST['stock'];

// SQL query สำหรับเพิ่มข้อมูลลงในตาราง fruits
$sql = "INSERT INTO fruits (fruit_id, fruit_name, price_per_unit, unit, stock) 
        VALUES ('$fruit_id', '$fruit_name', '$price_per_unit', '$unit', '$stock')";

// execute query
if ($conn->query($sql) === TRUE) {
  echo "New fruit/vegetable added successfully!";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>