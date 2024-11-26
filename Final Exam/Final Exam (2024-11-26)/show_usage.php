<?php include 'connection.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title>Show Usage</title>
    <link rel="stylesheet" href="style.css">
    <script>
    function showUsage(smoothieId) {
        // ใช้ AJAX เพื่อดึงข้อมูลการใช้งานจาก show_usage_ajax.php
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("usageDetails").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "show_usage_ajax.php?smoothie_id=" + smoothieId, true);
        xhttp.send();
    }
    </script>
</head>

<body>
    <h2>Show Usage</h2>

    <label for="smoothie_list">Select Smoothie:</label><br>
    <select id="smoothie_list" name="smoothie_list" onchange="showUsage(this.value)">
        <option value="">Select a smoothie</option>
        <?php
    // SQL query for selecting smoothies ordered by the number of ingredients, then by total quantity
    $sql = "SELECT s.smoothie_id, s.smoothie_name, COUNT(r.fruit_id) AS ingredient_count, SUM(r.quantity) AS total_quantity
            FROM smoothies s
            JOIN recipes r ON s.smoothie_id = r.smoothie_id
            GROUP BY s.smoothie_id, s.smoothie_name
            ORDER BY ingredient_count DESC, total_quantity DESC";

    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
      $smoothie_name = $row['smoothie_name'];
      $ingredient_count = $row['ingredient_count'];
      $total_quantity = $row['total_quantity'];

      echo "<option value='" . $row['smoothie_id'] . "'>" . $smoothie_name . " (" . $ingredient_count . " ingredients, " . $total_quantity . " total)</option>";
    }
    ?>
    </select>

    <div id="usageDetails">
    </div>
</body>

</html>