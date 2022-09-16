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


if(array_key_exists('category',$_POST)){
 

$error       =array();
$valid       =$_POST['envoyer'];


if(isset($valid)){

if( !intval( $_POST['category'] ) ) {
  $error['category'] = 'Choisir une catégorie';
}
}



  $query = $pdo -> prepare(
    '
    INSERT INTO 
    `category`
    (`category`) VALUES (?)
            
    ');
  
    $query->execute(array($_POST['category']
    )
  );
    
    // $new_id = $pdo->lastInsertId();

    // Rediriger sur la page show_post
    // header('Location: index.php?id=' . $new_id );
    header('Location: admin_category_index.php');
    exit();
  
 
}



$template = 'admin_category_insert';
include 'layout.phtml';

} catch (PDOException $e) {

die("Impossible de se connecter à la base de données $dbname :" . $e->getMessage());

}

?>