<?php
require_once 'db.php';

$id_cars = isset($_GET['id_cars']) ? (int)$_GET['id_cars'] : 0;

$stmt = $pdo->prepare("SELECT * FROM cars WHERE id_cars = :id_cars");
$stmt->execute([':id_cars' => $id_cars]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$car) {
    header('Location: index.php');
    exit;
}

$stmt_features = $pdo->prepare("SELECT * FROM car_details WHERE id_cars = :id_cars");
$stmt_features->execute([':id_cars' => $id_cars]);
$features = $stmt_features->fetch(PDO::FETCH_ASSOC);

$stmt_suggestions = $pdo->prepare("SELECT * FROM cars WHERE manufacturer = :manufacturer AND id_cars != :id_cars LIMIT 3");
$stmt_suggestions->execute([
    ':manufacturer' => $car['manufacturer'],
    ':id_cars' => $car['id_cars']
]);

$suggestions = $stmt_suggestions->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $car['manufacturer'] . ' ' . $car['model']; ?> - Luxury Auto</title>
    <link rel="stylesheet" href="details.css">
</head>
<body>
    <header>
        <h1>Luxury Auto</h1>
    </header>

    <main>
        <div class="details-container">
            <div class="details-grid">
                <div class="details-image">
                    <?php if (!empty($car['image_url'])): ?>
                        <img src="<?php echo $car['image_url']; ?>" 
                             alt="<?php echo $car['manufacturer'] . ' ' . $car['model']; ?>">
                    <?php else: ?>
                        <div class="no-image">No Image</div>
                    <?php endif; ?>
                </div>
                
                <div class="details-info">
                    <h1><?php echo $car['manufacturer'] . ' ' . $car['model']; ?></h1>
                    
                    <div class="specs-grid">
                        <?php if ($features && !empty($features['engine_type'])): ?>
                        <div class="spec-item">
                            <div class="spec-label">Moteur</div>
                            <div class="spec-value"><?php echo $features['engine_type']; ?></div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($features && !empty($features['horsepower'])): ?>
                        <div class="spec-item">
                            <div class="spec-label">Puissance</div>
                            <div class="spec-value"><?php echo $features['horsepower']; ?> <small>ch</small></div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($features && !empty($features['fuel_type'])): ?>
                        <div class="spec-item">
                            <div class="spec-label">Carburant</div>
                            <div class="spec-value"><?php echo $features['fuel_type']; ?></div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($features && !empty($features['consumption'])): ?>
                        <div class="spec-item">
                            <div class="spec-label">Consommation</div>
                            <div class="spec-value"><?php echo $features['consumption']; ?> <small>L/100km</small></div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($features && !empty($features['acceleration'])): ?>
                        <div class="spec-item">
                            <div class="spec-label">0-100 km/h</div>
                            <div class="spec-value"><?php echo $features['acceleration']; ?> <small>sec</small></div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($features && !empty($features['top_speed'])): ?>
                        <div class="spec-item">
                            <div class="spec-label">Vitesse max</div>
                            <div class="spec-value"><?php echo $features['top_speed']; ?> <small>km/h</small></div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($features && !empty($features['weight'])): ?>
                        <div class="spec-item">
                            <div class="spec-label">Poids</div>
                            <div class="spec-value"><?php echo $features['weight']; ?> <small>kg</small></div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($features && !empty($features['trunk_capacity'])): ?>
                        <div class="spec-item">
                            <div class="spec-label">Coffre</div>
                            <div class="spec-value"><?php echo $features['trunk_capacity']; ?> <small>L</small></div>
                        </div>
                        <?php endif; ?>

                        <?php if ($features && !empty($features['transmission'])): ?>
                        <div class="spec-item">
                            <div class="spec-label">Transmission</div>
                            <div class="spec-value"><?php echo $features['transmission']; ?> </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($features && !empty($features['type'])): ?>
                        <div class="spec-item">
                            <div class="spec-label">Type</div>
                            <div class="spec-value"><?php echo $features['type']; ?> </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($features && !empty($features['release_date'])): ?>
                        <div class="spec-item">
                            <div class="spec-label">Date de sortie</div>
                            <div class="spec-value"><?php echo $features['release_date']; ?> </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($features && !empty($features['price'])): ?>
                        <div class="spec-item">
                            <div class="spec-label">Prix</div>
                            <div class="spec-value"><?php echo number_format($features['price'], 0, ',', ' '); ?> <small>€</small></div>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if ($features && !empty($features['colors'])): ?>
                    <div class="colors-section">
                        <h3>Couleurs disponibles</h3>
                        <div class="color-tags">
                            <?php 
                            $colors = explode(',', $features['colors']);
                            foreach ($colors as $color): 
                            ?>
                                <span class="color-tag"><?php echo trim($color); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php if ($features && !empty($features['description'])): ?>
            <div class="description-section">
                <h2>Description</h2>
                <p><?php echo nl2br($features['description']); ?></p>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($suggestions)): ?>
            <div class="suggestions">
                <h2>Autres modèles <?php echo $car['manufacturer']; ?></h2>
                <div class="suggestions-grid">
                    <?php foreach ($suggestions as $suggestion): ?>
                        <a href="details.php?id_cars=<?php echo $suggestion['id_cars']; ?>" class="card-link">
                            <div class="card">
                                <div class="card-image">
                                    <?php if (!empty($suggestion['image_url'])): ?>
                                        <img src="<?php echo $suggestion['image_url']; ?>" 
                                             alt="<?php echo $suggestion['manufacturer'] . ' ' . $suggestion['model']; ?>">
                                    <?php else: ?>
                                        <div class="no-image">No Image</div>
                                    <?php endif; ?>
                                </div>
                                <h1><?php echo $suggestion['manufacturer'] . ' ' . $suggestion['model']; ?></h1>
                                <p>Type: <?php echo $suggestion['type']; ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class= "button">
            <a href="index.php">Retour à l'accueil</a>
        </div>

    </main>
</body>
</html>