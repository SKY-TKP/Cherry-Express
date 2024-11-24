<?php include 'connection.php'; ?>

<?php
if (isset($_GET["agency_id"])) {
  $agency_id = $_GET["agency_id"];

  $sql = "DELETE FROM advertisements WHERE agency_id='$agency_id'";

  if ($conn->query($sql) === TRUE) {
    echo "ลบโฆษณาของเอเจนซี่สำเร็จ";
    // Redirect back to admin.php
    header("Location: admin.php"); 
    exit();
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
$conn->close();
?>
