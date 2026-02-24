<?php
require_once 'db.php';

$search_manufacturer = isset($_GET['manufacturer']) ? trim($_GET['manufacturer']) : '';
$search_model = isset($_GET['model']) ? trim($_GET['model']) :'';
$search_year = isset($_GET['year']) ? trim($_GET['year']) : '';
$search_type = isset($_GET['type']) ? trim($_GET['type']) : '';
$search_transmission = isset($_GET['transmission']) ? trim($_GET['transmission']) : '';

$sql = "SELECT * FROM cars WHERE 1=1";
$params = [];

if (!empty($search_manufacturer)) {
    $sql .= " AND manufacturer LIKE :manufacturer";
    $params[':manufacturer'] = '%' . $search_manufacturer . '%';
}

if (!empty($search_model)) {
    $sql .= " AND model LIKE :model";
    $params[':model'] = '%' . $search_model . '%';
}

if (!empty($search_year)) {
    $sql .= " AND YEAR(release_date) = :year";
    $params[':year'] = $search_year;
}

if (!empty($search_type)) {
    $sql .= " AND type = :type";
    $params[':type'] = $search_type;
}

if (!empty($search_transmission)) {
    $sql .= " AND transmission = :transmission";
    $params[':transmission'] = $search_transmission;
}

$sql .= " ORDER BY manufacturer, model";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt_types = $pdo->prepare("SELECT DISTINCT type FROM cars ORDER BY type");
$stmt_types->execute();
$types = $stmt_types->fetchAll(PDO::FETCH_ASSOC);

$stmt_trans = $pdo->prepare("SELECT DISTINCT transmission FROM cars ORDER BY transmission");
$stmt_trans->execute();
$transmissions = $stmt_trans->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxury Auto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Luxury Auto</h1>
        <form method="GET" action="index.php" class="search-form">
            <div class="form-group">
                <label for="manufacturer">Fabriquant :</label>
                <input 
                type="text"
                id="manufacturer"
                name="manufacturer"
                placeholder="Toyota, BMW..."
                value= "<?php echo($search_manufacturer); ?>"
                >
            </div>

            <div class="form-group">
            <label for="model">Modèle :</label>
            <input 
                type="text" 
                id="model" 
                name="model" 
                placeholder="Corolla, X5..."
                 value= "<?php echo($search_model); ?>"
            >
            </div>

        <div class="form-group">
            <label for="year">Année :</label>
            <input 
                type="number" 
                id="year" 
                name="year" 
                placeholder="2020" 
                min="1900" 
                max="2030"
                value= "<?php echo($search_year); ?>"
            >
            </div>

         <div class="form-group">
            <label for="type">Type :</label>
            <select id="type" name="type">
                <option value="">Tous les types</option>
                <?php foreach ($types as $t): ?>
                    <option value="<?php echo($t['type']); ?>"
                        <?php echo ($search_type === $t['type']) ? 'selected' : ''; ?>>
                        <?php echo($t['type']); ?>
                    </option>
                <?php endforeach; ?>        
            </select>
        </div>

        <div class="form-group">
            <label for="transmission">Transmission :</label>
            <select id="transmission" name="transmission">
                <option value="">Toutes les transmissions</option>
                <?php foreach ($transmissions as $tr): ?>
                    <option value="<?php echo($tr['transmission']); ?>"
                        <?php echo ($search_transmission === $tr['transmission']) ? 'selected' : ''; ?>>
                        <?php echo($tr['transmission']); ?>
                    </option>
                <?php endforeach; ?>
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
                <a href= "details.php?id_cars=<?php echo $car['id_cars']; ?>" class="card-link">
                <div class = "card">
                    <div class="card-image">
                        <?php if (!empty($car['image_url'])): ?>
                            <img src="<?php echo($car['image_url']); ?>" 
                            alt="<?php echo($car['manufacturer'] . ' ' . $car['model']); ?>">
                        <?php else: ?>
                                <div class="no-image">No Image</div>
                        <?php endif; ?>
                    </div>            
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