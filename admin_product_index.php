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
    `author`.id AS `id_author`,
    `category`.id AS `id_category`,
    `title`, 
    SUBSTRING(`description`, 1,50) AS Excerpt,
    DATE_FORMAT(`date_creation`, "%W %e %M %Y" ) AS DateMaj,
    DATE_FORMAT(`date_creation`, "%Y-%d-%d" ) AS DateIso, 
    `image`,
    `price_sale`,
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
  $products = $query->fetchAll();

  $countproducts = $query->rowCount();
  
  if(empty($products)){
    $msg= "0 resultat";
}
  
  $query->closeCursor();




  
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

// Affichage
$template = 'admin_product_index';
include 'layout.phtml';


} catch (PDOException $e) {

die("Impossible de se connecter à la base de données $dbname :" . $e->getMessage());

}



// include 'index.phtml';