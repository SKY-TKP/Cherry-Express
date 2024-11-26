<?php include 'connection.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title>Add/Edit Smoothie</title>
    <link rel="stylesheet" href="style.css">
    <script>
    function addIngredient() {
        var container = document.getElementById('ingredientsContainer');
        var newRow = document.createElement('div');
        newRow.innerHTML = `
        <select name="fruit_id[]">
          <?php
            $sql = "SELECT fruit_id, fruit_name FROM fruits";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
              echo "<option value='" . $row['fruit_id'] . "'>" . $row['fruit_name'] . "</option>";
            }
          ?>
        </select>
        <input type="number" name="quantity[]" step="1" min="1" value="1" placeholder="Quantity" required>
        <button type="button" onclick="removeIngredient(this)">Remove</button>
      `;
        container.appendChild(newRow);
    }

    function removeIngredient(button) {
        var row = button.parentNode;
        row.parentNode.removeChild(row);
    }
    </script>
</head>

<body>
    <h2>Add/Edit Smoothie</h2>

    <?php
  // Check if smoothie_id is provided for editing
  if (isset($_GET['smoothie_id'])) {
    $smoothie_id = $_GET['smoothie_id'];
    $sql = "SELECT * FROM smoothies WHERE smoothie_id = $smoothie_id";
    $result = $conn->query($sql);
    $smoothie = $result->fetch_assoc();

    // Fetch existing ingredients
    $sql = "SELECT fruit_id, quantity FROM recipes WHERE smoothie_id = $smoothie_id";
    $result = $conn->query($sql);
    $ingredients = array();
    while ($row = $result->fetch_assoc()) {
      $ingredients[] = $row;
    }
  }
  ?>

    <form action="process_smoothie.php" method="post">
        <input type="hidden" name="smoothie_id" value="<?php echo isset($smoothie) ? $smoothie['smoothie_id'] : ''; ?>">

        <label for="smoothie_name">Smoothie Name:</label><br>
        <input type="text" id="smoothie_name" name="smoothie_name"
            value="<?php echo isset($smoothie) ? $smoothie['smoothie_name'] : ''; ?>" required><br><br>

        <h3>Ingredients:</h3>
        <div id="ingredientsContainer">
            <?php if (isset($ingredients)): ?>
            <?php foreach ($ingredients as $ingredient): ?>
            <div>
                <select name="fruit_id[]">
                    <?php
              $sql = "SELECT fruit_id, fruit_name FROM fruits";
              $result = $conn->query($sql);
              while ($row = $result->fetch_assoc()) {
                $selected = ($row['fruit_id'] == $ingredient['fruit_id']) ? 'selected' : '';
                echo "<option value='" . $row['fruit_id'] . "' $selected>" . $row['fruit_name'] . "</option>";
              }
              ?>
                </select>
                <input type="number" name="quantity[]" step="1" min="1" value="<?php echo $ingredient['quantity']; ?>"
                    placeholder="Quantity" required>
                <button type="button" onclick="removeIngredient(this)">Remove</button>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <div>
                <select name="fruit_id[]">
                    <?php
            $sql = "SELECT fruit_id, fruit_name FROM fruits";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
              echo "<option value='" . $row['fruit_id'] . "'>" . $row['fruit_name'] . "</option>";
            }
            ?>
                </select>
                <input type="number" name="quantity[]" step="1" min="1" value="1" placeholder="Quantity" required>
                <button type="button" onclick="removeIngredient(this)">Remove</button>
            </div>
            <?php endif; ?>
        </div>

        <button type="button" onclick="addIngredient()">Add Ingredient</button><br><br>
        <input type="submit" value="<?php echo isset($smoothie) ? 'Update' : 'Add'; ?>">
    </form>

    <h2>Smoothie List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
      $sql = "SELECT * FROM smoothies";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row['smoothie_id'] . "</td>";
          echo "<td>" . $row['smoothie_name'] . "</td>";
          echo "<td><a href='?smoothie_id=" . $row['smoothie_id'] . "'>Edit</a> | <a href='delete_smoothie.php?smoothie_id=" . $row['smoothie_id'] . "'>Delete</a></td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='3'>No smoothies found</td></tr>";
      }
      ?>
        </tbody>
    </table>
</body>

</html>