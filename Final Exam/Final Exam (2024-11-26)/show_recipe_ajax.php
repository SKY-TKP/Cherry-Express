<?php include 'connection.php'; 

if (isset($_GET['smoothie_id'])) {
  $smoothie_id = $_GET['smoothie_id'];

  // ดึงข้อมูลสูตรจากตาราง recipes
  $sql = "SELECT r.quantity, f.fruit_name 
          FROM recipes r
          JOIN fruits f ON r.fruit_id = f.fruit_id
          WHERE r.smoothie_id = '$smoothie_id'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    echo "<h3>Ingredients:</h3>";
    echo "<ul>";
    while($row = $result->fetch_assoc()) {
      echo "<li>" . $row["fruit_name"] . " - " . $row["quantity"] . " " .  "</li>"; // You might need to adjust the unit display
    }
    echo "</ul>";
    // เพิ่มส่วนสำหรับแก้ไขสูตร (เพิ่ม/ลบ ส่วนผสม) ที่นี่
  } else {
    echo "No recipe found for this smoothie.";
  }
}
?>