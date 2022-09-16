<?php
session_start();

$host = 'localhost';
$dbname = '3jeja';
$username = 'root';
$password = '';

try {

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// echo "Connecté à $dbname sur $host avec succès.";

$author       ='';
$valid        ='';
$title        ='';
$category     ='';
$photo        ='';
$description  ='';
$price  ='';


if(array_key_exists('titlep',$_POST)){
 

$error       =array();
$valid       =$_POST['envoyer'];
$author      =$_POST['nameauth'];
$title       =$_POST['titlep'];
$category    =$_POST['categories'];
$description =$_POST['description'];
$photo       =$_POST['photo'];
$price       =$_POST['price'];

if(isset($valid)){

if( !intval( $_POST['nameauth'] ) ) {
  $error['nameauth'] = 'Choisir un auteur';
}

if( !intval( $_POST['categories'] ) ) {
  $error['categories'] = 'Choisir une catégorie';
}

if( empty( $_POST['titlep'] ) ) {
  $error['titlep'] = 'Le titre de l\'article est obligatoire';
}

if( empty( $_POST['description'] ) ) {
  $error['description'] = 'Rédiger votre article !';
}
else if( mb_strlen( $_POST['description'] ) > 10000 OR mb_strlen( $_POST['description'] ) < 10  ) {
  $error['description'] = 'L article doit contenir un minimum de 10 caractères et un maximum de 10000';
}

if( empty( $_POST['photo'] ) ) {
  $error['photo'] = 'Choisir une photo';
}

if( !intval( $_POST['price'] ) ) {
  $error['price'] = 'le prix est obligatoire!';
}
}
if(empty($error)){


  $query = $pdo -> prepare(
    '
    INSERT INTO 
    `products`
          (`title`, `description`, `date_creation`, `image`, `price_sale`, `id_author`, `id_category`)
     VALUES 
          ( ?, ?, NOW(), ?, ?, ?, ?)
            
    ');
  
    $query->execute(array(
      $_POST['titlep'],
      $_POST['description'],
      $_POST['photo'],
      $_POST['price'],
      $_POST['nameauth'],
      $_POST['categories']
    )
  );
    
    $new_id = $pdo->lastInsertId();

    // Rediriger sur la page show_post
    // header('Location: index.php?id=' . $new_id );
    header('Location: index.php');
    exit();
  
 }
}

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



$template = 'add_product';
include 'layout.phtml';

} catch (PDOException $e) {

die("Impossible de se connecter à la base de données $dbname :" . $e->getMessage());

}

?>