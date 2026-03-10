<?php

$host = 'sql306.infinityfree.com';

$dbname = 'if0_41352688_XXX';

$username = 'if0_41352688';

$password = '02andre03';

try {

    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8" , $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {

    die("Erreur de connexion : " . $e->getMessage());
}

?>