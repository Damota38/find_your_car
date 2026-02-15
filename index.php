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
        <form method="GET" action="index.php" class="search-form">
            <div class="form-group">
                <label for="manufacturer">Fabriquant :</label>
                <input 
                type="text"
                id="manufacturer"
                name="manufacturer"
                placeholder="Ex: Toyota, BMW..."
                >
            </div>

            <div class="form-group">
            <label for="model">Modèle :</label>
            <input 
                type="text" 
                id="model" 
                name="model" 
                placeholder="Ex: Corolla, X5..."
            >
        </div>

        <div class="form-group">
            <label for="year">Année :</label>
            <input 
                type="number" 
                id="year" 
                name="year" 
                placeholder="Ex: 2020" 
                min="1900" 
                max="2030"
            >
        </div>

         <div class="form-group">
            <label for="type">Type :</label>
            <select id="type" name="type">
                <option value="">Tous les types</option>
                <option value="SUV">SUV</option>
                <option value="Sedan">Sedan</option>
                <option value="Hatchback">Hatchback</option>
                <option value="Coupe">Coupe</option>
                <option value="Pickup">Pickup</option>
                <option value="Roadster">Roadster</option>
            </select>
        </div>

        <div class="form-group">
            <label for="transmission">Transmission :</label>
            <select id="transmission" name="transmission">
                <option value="">Toutes les transmissions</option>
                <option value="Manual">Manuelle</option>
                <option value="Automatic">Automatique</option>
                <option value="CVT">CVT</option>
            </select>
        </div>

        <div class="form-group">
            <button type="submit">Rechercher</button>
        </div>
    </form>

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