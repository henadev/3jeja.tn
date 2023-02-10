<?php

session_start();

$host = 'localhost';
$dbname = '3jeja';
$username = 'root';
$password = '';

try {

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// echo "Connecté à $dbname sur $host avec succès.";
$id_product = $_GET['id'];
// var_dump('');

$query = $pdo -> prepare(
  '
  SELECT 
     products.id,
    `title`, 
   `description`,
   `price_sale`,
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
  WHERE
  `products`.id =?
          
  ');

  $query->execute(array($id_product));
  $product = $query->fetch(); 
  
  $query->closeCursor();

// show comment
  $query = $pdo->prepare(
    '
    SELECT 
     `comment`,
     DATE_FORMAT(`date_comment`, "%W %e %M %Y" ) AS DateMaj,
     DATE_FORMAT(`date_comment`, "%Y-%d-%d" ) AS DateIso, 
     `pseudo` 
    FROM
      `comment`
    WHERE 
    `id_product`=?
    ');

    $query -> execute(array( $product['id'] ));
    $comments = $query->fetchAll();
    $query -> closeCursor();


// Affichage
$template = 'show_product';
include 'layout.phtml';


} catch (PDOException $e) {

die("Impossible de se connecter à la base de données $dbname :" . $e->getMessage());

}



// include 'index.phtml';