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
  DELETE
  FROM 
  `comment`
   WHERE 
  id = ?   
  ');

  $query->execute(array($_GET['id']));
  $query->closeCursor();

  header('Location: admin_comment_index.php');
  exit();

// Affichage
$template = 'admin_comment_index';
include 'layout.phtml';


} catch (PDOException $e) {

die("Impossible de se connecter à la base de données $dbname :" . $e->getMessage());

}



// include 'index.phtml';