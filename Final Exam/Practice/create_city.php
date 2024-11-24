<?php include 'connection.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>สร้างเมืองเป้าหมาย</title>
</head>
<body>
  <h2>สร้างเมืองเป้าหมาย</h2>

  <?php
  // เพิ่มเมือง
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $city_name = $_POST["city_name"];
    $slogan = $_POST["slogan"];
    $days = $_POST["days"];

    $sql = "INSERT INTO cities (city_name, slogan, days) VALUES ('$city_name', '$slogan', '$days')";

    if ($conn->query($sql) === TRUE) {
      echo "เพิ่มเมืองสำเร็จ";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }

  // แก้ไขเมือง
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $city_id = $_POST["city_id"];
    $city_name = $_POST["city_name"];
    $slogan = $_POST["slogan"];
    $days = $_POST["days"];

    $sql = "UPDATE cities SET city_name='$city_name', slogan='$slogan', days='$days' WHERE id='$city_id'";

    if ($conn->query($sql) === TRUE) {
      echo "แก้ไขเมืองสำเร็จ";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }

  // ลบเมือง
  if (isset($_GET["delete"])) {
    $city_id = $_GET["delete"];

    // ตรวจสอบว่ามีผู้สนใจเมืองนี้หรือไม่
    $check_sql = "SELECT COUNT(*) FROM travelers WHERE city_id = '$city_id'";
    $result = $conn->query($check_sql);
    $row = $result->fetch_assoc();
    $count = $row['COUNT(*)'];

    if ($count > 0) {
      echo "ไม่สามารถลบเมืองนี้ได้ เนื่องจากมีผู้สนใจแล้ว";
    } else {
      $sql = "DELETE FROM cities WHERE id='$city_id'";

      if ($conn->query($sql) === TRUE) {
        echo "ลบเมืองสำเร็จ";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
  }

  // แสดงฟอร์มเพิ่มเมือง
  ?>
  <h3>เพิ่มเมือง</h3>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    ชื่อเมือง: <input type="text" name="city_name"><br>
    คำโฆษณา: <input type="text" name="slogan"><br>
    จำนวนวันที่ควรเที่ยว: <input type="number" name="days"><br><br>
    <input type="submit" name="submit" value="เพิ่มเมือง">
  </form>

  <?php
  // แสดงรายชื่อเมือง
  $sql = "SELECT * FROM cities";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    echo "<h3>รายชื่อเมือง</h3>";
    echo "<table border='1'>
    <tr>
      <th>ID</th>
      <th>ชื่อเมือง</th>
      <th>คำโฆษณา</th>
      <th>จำนวนวันที่ควรเที่ยว</th>
      <th>แก้ไข</th>
      <th>ลบ</th>
    </tr>";
    while($row = $result->fetch_assoc()) {
      echo "<tr>
      <td>".$row["id"]."</td>
      <td>".$row["city_name"]."</td>
      <td>".$row["slogan"]."</td>
      <td>".$row["days"]."</td>
      <td><a href='?edit=".$row["id"]."'>แก้ไข</a></td>
      <td><a href='?delete=".$row["id"]."'>ลบ</a></td>
      </tr>";
    }
    echo "</table>";
  } else {
    echo "ยังไม่มีเมือง";
  }

  // แสดงฟอร์มแก้ไขเมือง
  if (isset($_GET["edit"])) {
    $city_id = $_GET["edit"];
    $sql = "SELECT * FROM cities WHERE id='$city_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    ?>
    <h3>แก้ไขเมือง</h3>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      <input type="hidden" name="city_id" value="<?php echo $row["id"]; ?>">
      ชื่อเมือง: <input type="text" name="city_name" value="<?php echo $row["city_name"]; ?>"><br>
      คำโฆษณา: <input type="text" name="slogan" value="<?php echo $row["slogan"]; ?>"><br>
      จำนวนวันที่ควรเที่ยว: <input type="number" name="days" value="<?php echo $row["days"]; ?>"><br><br>
      <input type="submit" name="update" value="บันทึก">
    </form>
    <?php
  }
  ?>

</body>
</html>
