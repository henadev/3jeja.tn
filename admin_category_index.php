<?php
session_start();

$host = 'localhost';
$dbname = '3jeja';
$username = 'root';
$password = '';

try {

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// echo "Connecté à $dbname sur $host avec succès.";

  
$query = $pdo->query
(
  'SELECT
        id,
        category
    FROM
        category'
);

// Une fois la requête exécutée, on récupère
$categories = $query->fetchAll();
// Réinitialiser le pointer ( En cas de requêtes multiples, on peut utiliser le même objet)
$query -> closeCursor();

if(empty($products)){
    $msg= "0 resultat";
}

$countcategory = $query->rowCount();

// Affichage
$template = 'admin_category_index';
include 'layout.phtml';


} catch (PDOException $e) {

die("Impossible de se connecter à la base de données $dbname :" . $e->getMessage());

}



// include 'index.phtml';