<?php

session_start();


$host = 'localhost';
$dbname = '3jeja';
$username = 'root';
$password = '';

try {

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// echo "Connecté à $dbname sur $host avec succès.";

if(array_key_exists('inputEmail',$_POST)){

$error       =array();
if( empty( $_POST['FirstName'] ) ) {
    $error['FirstName'] = 'Le champ est obligatoire';
  }
if( empty( $_POST['LastName'] ) ) {
    $error['LastName'] = 'Le champ est obligatoire';
  }
if( !filter_var($_POST['inputEmail'], FILTER_VALIDATE_EMAIL) ) {
    $error['inputEmail'] = 'verifier l email';
  }
if( empty( $_POST['inputPassword'] ) ) {
    $error['inputPassword'] = 'Le champ est obligatoire';
  }
if( empty( $_POST['inputAddress'] ) ) {
    $error['inputAddress'] = 'Le champ est obligatoire';
  } 
  
if(empty($error)){
$query = $pdo -> prepare(
    'INSERT INTO
     `author`
     (`firstname`, `lastname`, `email`, `password`, `address`) 
     VALUES 
     (?,?,?,?,?)
     ');
$query->execute(array(
    $_POST['FirstName'],
    $_POST['LastName'],
    $_POST['inputEmail'],
    $_POST['inputPassword'],
    $_POST['inputAddress']
));


header('Location: login.php');
exit();

}
}
$template = 'registre_auth';
include 'layout.phtml';



} catch (PDOException $e) {

die("Impossible de se connecter à la base de données $dbname :" . $e->getMessage());

}

?>