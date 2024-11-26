<?php
include 'connection.php';

if (isset($_GET['smoothie_id'])) {
  $smoothie_id = $_GET['smoothie_id'];

  // Delete ingredients first due to foreign key constraint
  $sql = "DELETE FROM recipes WHERE smoothie_id = $smoothie_id";
  if ($conn->query($sql) === TRUE) {
    $sql = "DELETE FROM smoothies WHERE smoothie_id = $smoothie_id";
    if ($conn->query($sql) === TRUE) {
      echo "Smoothie deleted successfully!";
    } else {
      echo "Error deleting smoothie: " . $conn->error;
    }
  } else {
    echo "Error deleting ingredients: " . $conn->error;
  }
}

$conn->close();
?>