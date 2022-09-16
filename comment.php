<?php

$host = 'localhost';
$dbname = '3jeja';
$username = 'root';
$password = '';

try {

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// echo "Connecté à $dbname sur $host avec succès.";

//   Insert comment
$error = array();

if(array_key_exists('pseudo',$_POST)){

  if(empty($_POST['pseudo'])){
      $error['pseudo'] = 'le champ est obligatoire!';
  } 
  if(empty($_POST['commentaire'])){
    $error['commentaire'] = 'le champ est obligatoire!';
} 

  if(empty($error)){
    $query = $pdo -> prepare(
    '
    INSERT INTO
     `comment` (`comment`, `id_product`, `date_comment`, `pseudo`)
    VALUES 
    (?,?,NOW(),?)
    ');
    $query->execute(array($_POST['commentaire'],$_POST['productId'],$_POST['pseudo']));

// Affichage
header('Location: show_product.php?id='.$_POST['productId']);
exit();
}}

// Affichage
// reste a mm page sans ajout le commentaire
header('Location: show_product.php?id='.$_POST['productId']);
exit();

} catch (PDOException $e) {

die("Impossible de se connecter à la base de données $dbname :" . $e->getMessage());

}



// include 'index.phtml';