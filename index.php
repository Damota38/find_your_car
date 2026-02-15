<?php
require_once 'db.php';

$sql = "SELECT * FROM cars ORDER BY manufactrer, model";

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

    
</body>
</html>