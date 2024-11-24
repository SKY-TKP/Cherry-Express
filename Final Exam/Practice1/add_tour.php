<link rel="stylesheet" href="style.css">
<?php include 'connection.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>เพิ่มทัวร์</title>
</head>
<body>
  <h2>เพิ่มทัวร์</h2>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company_name = $_POST["company_name"];
    $price = $_POST["price"];
    $days = $_POST["days"];
    $city_id = $_POST["city_id"];

    $sql = "INSERT INTO tours (company_name, price, days, city_id) VALUES ('$company_name', '$price', '$days', '$city_id')";

    if ($conn->query($sql) === TRUE) {
      echo "เพิ่มทัวร์สำเร็จ";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
  ?>

  <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    ชื่อบริษัท: <input type="text" name="company_name"><br>
    ราคา: <input type="number" name="price"><br>
    จำนวนวัน: <input type="number" name="days"><br>
    <input type="hidden" name="city_id" value="<?php echo $_GET["city_id"]; ?>"><br><br>
    <input type="submit" value="เพิ่มทัวร์">
  </form>
</body>
</html>
