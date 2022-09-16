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
        comment
    FROM
        comment'
);

// Une fois la requête exécutée, on récupère
$comments = $query->fetchAll();
// Réinitialiser le pointer ( En cas de requêtes multiples, on peut utiliser le même objet)
$query -> closeCursor();

if(empty($comments)){
    $msg= "0 resultat";
}

$countcomment = $query->rowCount();

// Affichage
$template = 'admin_comment_index';
include 'layout.phtml';


} catch (PDOException $e) {

die("Impossible de se connecter à la base de données $dbname :" . $e->getMessage());

}



// include 'index.phtml';