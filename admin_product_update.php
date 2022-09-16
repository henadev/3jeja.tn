<?php

$host = 'localhost';
$dbname = '3jeja';
$username = 'root';
$password = '';

try {

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// echo "Connecté à $dbname sur $host avec succès.";


if(array_key_exists('titlep',$_POST)){

  $query = $pdo -> prepare(
    '
    UPDATE
     `products`
    SET
       `title`= :title,
       `description`= :description,
       `date_creation`= NOW(),
       `image`= :image,
       `price_sale`= :price_sale,
       `id_author`= :id_author,
       `id_category`= :id_category
    WHERE 
         `id`= :id   
    ');
  
    $query->execute(array(
        'title' => $_POST['titlep'],
        'description' => $_POST['description'],
        'image' => $_POST['photo'],
        'price_sale' => $_POST['price'],
        'id_author' => $_POST['nameauth'],
        'id_category' => $_POST['categories'],
        'id' =>  $_POST['id'] 
    )
  );
    
    header('Location: admin_product_index.php');
    exit();
}

// if( !array_key_exists('id', $_GET) OR !ctype_digit($_GET['id']) ) {
//   header('Location: admin_product_index.php');
//   exit();
// }

$query = $pdo -> prepare(
  '
  SELECT 
    `products`.id ,
    `id_author`,
    `id_category`,
    `title`, 
    SUBSTRING(`description`, 1,50) AS Excerpt,
    DATE_FORMAT(`date_creation`, "%W %e %M %Y" ) AS DateMaj,
    DATE_FORMAT(`date_creation`, "%Y-%d-%d" ) AS DateIso, 
    `image`,
    `price_sale`
  FROM 
      `products`
  WHERE 
  `products`.id = ?
          
  ');

  $query->execute(array($_GET['id']));
  $product = $query->fetch();



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
// // Réinitialiser le pointer
$query -> closeCursor();


$template = 'admin_product_update';
include 'layout.phtml';

} catch (PDOException $e) {

die("Impossible de se connecter à la base de données $dbname :" . $e->getMessage());

}

?>