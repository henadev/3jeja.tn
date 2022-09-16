<?php
session_start();

$host = 'localhost';
$dbname = '3jeja';
$username = 'root';
$password = '';

try {

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// echo "Connecté à $dbname sur $host avec succès.";

$query = $pdo -> prepare(
  '
  SELECT 
    `products`.id AS `id_product`,
    `title`, 
    SUBSTRING(`description`, 1,50) AS Excerpt,
    DATE_FORMAT(`date_creation`, "%W %e %M %Y" ) AS DateMaj,
    DATE_FORMAT(`date_creation`, "%Y-%d-%d" ) AS DateIso, 
    `image`,
    `category`,
    `firstname`,
    `lastname`
  FROM 
      `products`
  INNER JOIN
     `author`
  ON
  `author`.id=`products`.id_author
  INNER JOIN
      `category`
  ON
      `category`.id=`products`.`id_category`
  ORDER BY
      `date_creation` DESC
          
  ');

  $query->execute();
  $products = $query->fetchAll(); //contient les 6 derniers articles
  
  if(empty($products)){
    $msg= "0 resultat";
}
  
  $query->closeCursor();

// Affichage
$template = 'All_product';
include 'layout.phtml';


} catch (PDOException $e) {

die("Impossible de se connecter à la base de données $dbname :" . $e->getMessage());

}



// include 'index.phtml';