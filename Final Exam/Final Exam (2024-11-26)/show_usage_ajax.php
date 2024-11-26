<?php include 'connection.php';

if (isset($_GET['smoothie_id'])) {
  $smoothie_id = $_GET['smoothie_id'];

  // ดึงข้อมูลส่วนผสมและราคา
  $sql = "SELECT f.fruit_name, r.quantity, f.price_per_unit, (r.quantity * f.price_per_unit) AS total_cost
          FROM recipes r
          JOIN fruits f ON r.fruit_id = f.fruit_id
          WHERE r.smoothie_id = '$smoothie_id'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    echo "<h3>Ingredients:</h3>";
    echo "<table>";
    echo "<tr><th>Fruit</th><th>Quantity</th><th>Price per Unit</th><th>Total Cost</th></tr>";
    $overall_total = 0;
    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>" . $row["fruit_name"] . "</td>";
      echo "<td>" . $row["quantity"] . "</td>";
      echo "<td>" . $row["price_per_unit"] . "</td>";
      echo "<td>" . $row["total_cost"] . "</td>";
      echo "</tr>";
      $overall_total += $row["total_cost"];
    }
    echo "</table>";
    echo "<h3>Overall Total Cost: " . $overall_total . "</h3>";
  } else {
    echo "No usage data found for this smoothie.";
  }
}
?>