<?php include 'connection.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title>Smoothie Shop</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <h1>Welcome to our Smoothie Shop!</h1>
    <ul>
        <li><a href="add_fruit.php">Add Fruits/Vegetables</a></li>
        <li><a href="add_smoothie.php">Add/Edit Smoothie</a></li>
        <li><a href="show_recipe.php">Show Recipe</a></li>
        <li><a href="show_usage.php">Show Usage</a></li>
    </ul>

    <h2>Latest Smoothies</h2>
    <table>
        <thead>
            <tr>
                <th>Smoothie Name</th>
                <th>Total Cost</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // ดึงข้อมูล 5 smoothies ล่าสุด พร้อมราคารวม
            $sql = "SELECT s.smoothie_name, SUM(r.quantity * f.price_per_unit) AS total_cost
                    FROM smoothies s
                    JOIN recipes r ON s.smoothie_id = r.smoothie_id
                    JOIN fruits f ON r.fruit_id = f.fruit_id
                    GROUP BY s.smoothie_name
                    ORDER BY s.smoothie_id DESC
                    LIMIT 5";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["smoothie_name"] . "</td>";
                    echo "<td>" . $row["total_cost"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No smoothies found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Total Fruit Usage</h2>
    <div>
        <canvas id="fruitUsageChart"></canvas>
    </div>

    <?php
    $sql = "SELECT f.fruit_name, SUM(r.quantity) AS total_quantity
            FROM recipes r
            JOIN fruits f ON r.fruit_id = f.fruit_id
            GROUP BY f.fruit_name
            ORDER BY total_quantity DESC
            LIMIT 5";

    $result = $conn->query($sql);

    $fruit_names = array();
    $total_quantities = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $fruit_names[] = $row["fruit_name"];
            $total_quantities[] = $row["total_quantity"];
        }
    }
    ?>

    <script>
    var ctx = document.getElementById('fruitUsageChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($fruit_names); ?>,
            datasets: [{
                label: 'Total Quantity',
                data: <?php echo json_encode($total_quantities); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            width: 500,
            height: 300
        }
    });
    </script>

    <h2>Available Fruits/Vegetables</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price per Unit</th>
                <th>Unit</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM fruits";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["fruit_id"] . "</td>";
                    echo "<td>" . $row["fruit_name"] . "</td>";
                    echo "<td>" . $row["price_per_unit"] . "</td>";
                    echo "<td>" . $row["unit"] . "</td>";
                    echo "<td>" . $row["stock"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No fruits/vegetables found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>