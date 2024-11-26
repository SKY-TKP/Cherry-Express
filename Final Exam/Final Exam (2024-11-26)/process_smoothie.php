<?php
include 'connection.php';

$smoothie_id = $_POST['smoothie_id'];
$smoothie_name = $_POST['smoothie_name'];
$fruit_ids = $_POST['fruit_id'];
$quantities = $_POST['quantity'];

if ($smoothie_id) {
  // Update existing smoothie
  $sql = "UPDATE smoothies SET smoothie_name = '$smoothie_name' WHERE smoothie_id = $smoothie_id";
  if ($conn->query($sql) === TRUE) {
    // Delete existing ingredients
    $sql = "DELETE FROM recipes WHERE smoothie_id = $smoothie_id";
    $conn->query($sql);

    // Add new ingredients
    for ($i = 0; $i < count($fruit_ids); $i++) {
      $fruit_id = $fruit_ids[$i];
      $quantity = $quantities[$i];
      $sql = "INSERT INTO recipes (smoothie_id, fruit_id, quantity) 
              VALUES ($smoothie_id, $fruit_id, $quantity)";
      $conn->query($sql);
    }

    echo "Smoothie updated successfully!";
  } else {
    echo "Error updating smoothie: " . $conn->error;
  }
} else {
  // Add new smoothie (same as before)
  // ...
}

$conn->close();
?>