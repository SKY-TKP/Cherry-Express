<?php include 'connection.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>ดูทัวร์</title>
</head>
<body>
  <h2>ดูทัวร์</h2>

  <form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
    Email: <input type="email" name="email"><br><br>
    <input type="submit" value="แสดงทัวร์">
  </form>

  <?php
  if (isset($_GET["email"])) {
    $email = $_GET["email"];

    $sql = "SELECT t.company_name, t.price, t.days, c.city_name 
            FROM tours t
            INNER JOIN travelers tr ON t.city_id = tr.city_id
            INNER JOIN cities c ON t.city_id = c.id
            WHERE tr.email = '$email'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      echo "<h3>รายชื่อทัวร์</h3>";
      echo "<table border='1'>
      <tr>
        <th>ชื่อบริษัท</th>
        <th>ราคา</th>
        <th>จำนวนวัน</th>
        <th>เมือง</th>
      </tr>";
      while($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>".$row["company_name"]."</td>
        <td>".$row["price"]."</td>
        <td>".$row["days"]."</td>
        <td>".$row["city_name"]."</td>
        </tr>";
      }
      echo "</table>";
    } else {
      echo "ไม่พบข้อมูลทัวร์";
    }
  }
  ?>
</body>
</html>
