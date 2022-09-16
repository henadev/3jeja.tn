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
        firstname,
        lastname
    FROM
        author'
);

// Une fois la requête exécutée, on récupère
$authors = $query->fetchAll();
// Réinitialiser le pointer
$query -> closeCursor();
  $countauthors = $query->rowCount();
  
  if(empty($authors)){
    $msg= "0 resultat";
}
  
  $query->closeCursor();

// Affichage
$template = 'admin_author_index';
include 'layout.phtml';


} catch (PDOException $e) {

die("Impossible de se connecter à la base de données $dbname :" . $e->getMessage());

}



// include 'index.phtml';