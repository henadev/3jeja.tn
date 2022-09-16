<?php

$host = 'localhost';
$dbname = '3jeja';
$username = 'root';
$password = '';

try {

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// echo "Connecté à $dbname sur $host avec succès.";


if(array_key_exists('category',$_POST)){

  $query = $pdo -> prepare(
    '
    UPDATE
     `category`
    SET
       `category`= :category
    WHERE 
         `id`= :id   
    ');
  
    $query->execute(array(
        'category' => $_POST['category'],
        'id' =>  $_POST['id'] 
    )
  );
    
    header('Location: admin_category_index.php');
    exit();
}

// if( !array_key_exists('id', $_GET) OR !ctype_digit($_GET['id']) ) {
//   header('Location: admin_product_index.php');
//   exit();
// }

$query = $pdo-> prepare(
  'SELECT 
  `id`,
  `category`
   FROM `category`
    WHERE id = ?
');

$query->execute(array($_GET['id']));
// Une fois la requête exécutée, on récupère
$category = $query->fetch();
// Réinitialiser le pointer ( En cas de requêtes multiples, on peut utiliser le même objet)
$query -> closeCursor();



$template = 'admin_category_update';
include 'layout.phtml';

} catch (PDOException $e) {

die("Impossible de se connecter à la base de données $dbname :" . $e->getMessage());

}

?>