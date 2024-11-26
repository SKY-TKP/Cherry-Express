<?php
include 'connection.php';

// รับข้อมูลจากฟอร์ม
$smoothie_name = $_POST['smoothie_name'];
$fruit_ids = $_POST['fruit_id'];
$quantities = $_POST['quantity'];

// ... (โค้ดตรวจสอบ smoothie name ซ้ำ) ...

// เพิ่มข้อมูล smoothie ลงในตาราง smoothies
$sql = "INSERT INTO smoothies (smoothie_name) VALUES ('$smoothie_name')";
if ($conn->query($sql) === TRUE) {
  $smoothie_id = $conn->insert_id; // ดึง smoothie_id ที่เพิ่งเพิ่มเข้าไป

  // เพิ่มข้อมูลส่วนผสมลงในตาราง recipes และลด stock ในตาราง fruits
  for ($i = 0; $i < count($fruit_ids); $i++) {
    $fruit_id = $fruit_ids[$i];
    $quantity = $quantities[$i];

    // 1. เพิ่มข้อมูลส่วนผสมลงในตาราง recipes
    $sql = "INSERT INTO recipes (smoothie_id, fruit_id, quantity) 
            VALUES ('$smoothie_id', '$fruit_id', '$quantity')";
    if ($conn->query($sql) !== TRUE) {
      echo "Error adding ingredient: " . $conn->error;
      // ในกรณี error อาจต้อง rollback การเพิ่ม smoothie ด้วย
      break; 
    }

    // 2. ลด stock ในตาราง fruits
    $sql = "UPDATE fruits SET stock = stock - $quantity WHERE fruit_id = $fruit_id";
    if ($conn->query($sql) !== TRUE) {
      echo "Error updating stock: " . $conn->error;
      // ในกรณี error อาจต้อง rollback การเพิ่ม smoothie และส่วนผสมด้วย
      break;
    }
  }
  echo "New smoothie added successfully!";
} else {
  echo "Error adding smoothie: " . $conn->error;
}

$conn->close();
?>