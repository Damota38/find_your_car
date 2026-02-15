<?php
require_once 'db.php';

$sql = "SELECT * FROM cars ORDER BY manufacturer, model";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Your Car</title>
</head>
<body>
    <header>
        <h1>Find Your Car</h1>
    </header>

    <main>
        <div class="container">
            <?php foreach ($cars as $car): ?>
                <div class = "card">
                    <h1><?php echo($car['manufacturer'] . ' ' . $car['model']); ?></h1>
                    <p>Date: <?php echo($car['release_date']); ?></p>
                    <p>Type: <?php echo($car['type']); ?></p>
                    <p>Transmission: <?php echo($car['transmission']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </main>              

</body>
</html>