<?php include 'connection.php'; ?> 

<?php
$sql = "SELECT s.station_name, a.ad_name 
        FROM advertisements a
        JOIN stations s ON a.station_id = s.id
        ORDER BY s.station_name";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $current_station = "";
  while($row = $result->fetch_assoc()) {
    if ($row["station_name"] != $current_station) {
      $current_station = $row["station_name"];
      echo "<h3>".$current_station."</h3>";
      echo "<ul>";
    }
    echo "<li>".$row["ad_name"]."</li>";
  }
  echo "</ul>";
} else {
  echo "ไม่พบข้อมูลโฆษณา";
}
$conn->close();
?>
