<?php include 'connection.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title>Add Fruits/Vegetables</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h2>Add New Fruit/Vegetable</h2>
    <form action="add_fruit_process.php" method="post">
        <label for="fruit_id">Fruit ID:</label><br>
        <input type="number" id="fruit_id" name="fruit_id" min="1" required><br><br>

        <label for="fruit_name">Fruit Name:</label><br>
        <input type="text" id="fruit_name" name="fruit_name" required><br><br>

        <label for="price_per_unit">Price per Unit:</label><br>
        <input type="number" id="price_per_unit" name="price_per_unit" step="0.01" required><br><br>

        <label for="unit">Unit:</label><br>
        <select id="unit" name="unit">
            <option value="piece">piece</option>
            <option value="kilogram">kilogram</option>
            <option value="dozen">dozen</option>
        </select><br><br>

        <label for="stock">Stock:</label><br>
        <input type="number" id="stock" name="stock" required><br><br>

        <input type="submit" value="Submit">
    </form>
</body>

</html>