<?php include 'connection.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title>Show Recipe</title>
    <link rel="stylesheet" href="style.css">
    <script>
    function showRecipe(smoothieId) {
        // ใช้ AJAX เพื่อดึงสูตรจาก show_recipe_ajax.php
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("recipeDetails").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "show_recipe_ajax.php?smoothie_id=" + smoothieId, true);
        xhttp.send();
    }
    </script>
</head>

<body>
    <h2>Show Recipe</h2>

    <label for="smoothie_list">Select Smoothie:</label><br>
    <select id="smoothie_list" name="smoothie_list" onchange="showRecipe(this.value)">
        <option value="">Select a smoothie</option>
        <?php
      $sql = "SELECT smoothie_id, smoothie_name FROM smoothies";
      $result = $conn->query($sql);
      while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['smoothie_id'] . "'>" . $row['smoothie_name'] . "</option>";
      }
    ?>
    </select>

    <div id="recipeDetails">
    </div>
</body>

</html>