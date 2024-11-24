<?php include 'connection.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>เพิ่มรายชื่อผู้สนใจเที่ยว</title>
</head>
<body>
  <h2>เพิ่มรายชื่อผู้สนใจเที่ยว</h2>

  <?php
  // เพิ่มผู้สนใจเที่ยว
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $people = $_POST["people"];
    $budget = $_POST["budget"];
    $city_id = $_POST["city_id"];

    $sql = "INSERT INTO travelers (name, phone, email, people, budget, city_id) VALUES ('$name', '$phone', '$email', '$people', '$budget', '$city_id')";

    if ($conn->query($sql) === TRUE) {
      echo "เพิ่มผู้สนใจเที่ยวสำเร็จ";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
  ?>

  <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    ชื่อ: <input type="text" name="name"><br>
    เบอร์โทรศัพท์: <input type="text" name="phone"><br>
    Email: <input type="email" name="email"><br>
    จำนวนคน: <input type="number" name="people"><br>
    งบประมาณ: <input type="number" name="budget"><br>
    เมืองที่สนใจ: 
    <select name="city_id">
      <?php
      $sql = "SELECT * FROM cities";
      $result = $conn->query($sql);
      while($row = $result->fetch_assoc()) {
        echo "<option value='".$row["id"]."'>".$row["city_name"]."</option>";
      }
      ?>
    </select><br><br>
    <input type="submit" value="เพิ่ม">
  </form>
</body>
</html>
