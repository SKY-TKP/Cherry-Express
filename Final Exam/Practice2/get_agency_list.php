<?php include 'connection.php'; ?>

<?php
$sql = "SELECT ag.agency_name, SUM(a.days) as total_days
        FROM agencies ag
        LEFT JOIN advertisements a ON ag.id = a.agency_id
        GROUP BY ag.agency_name";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo "<table border='1'>
  <tr>
    <th>ชื่อเอเจนซี่</th>
    <th>จำนวนวันทั้งหมด</th>
    <th>ลบ</th> 
  </tr>";
  while($row = $result->fetch_assoc()) {
    echo "<tr>
    <td>".$row["agency_name"]."</td>
    <td>".$row["total_days"]."</td>
    <td><a href='delete_agency_ads.php?agency_id=".$row["id"]."'>ลบโฆษณา</a></td> 
    </tr>";
  }
  echo "</table>";
} else {
  echo "ไม่พบข้อมูลเอเจนซี่";
}
$conn->close();
?>
