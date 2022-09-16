<?php



$host = 'localhost';
$dbname = '3jeja';
$username = 'root';
$password = '';

try {

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// echo "Connecté à $dbname sur $host avec succès.";

if(array_key_exists('inputEmail',$_POST)){

    $error       =array();
    
    if( !filter_var($_POST['inputEmail'], FILTER_VALIDATE_EMAIL) ) {
        $error['inputEmail'] = 'verifier l email';
      }
    if( empty( $_POST['inputPassword'] ) ) {
        $error['inputPassword'] = 'Le champ est obligatoire';
      }
      
    if(empty($error)){
    $query = $pdo -> prepare(
        'SELECT *
        FROM `admin`
        WHERE
        `email`= ? AND
        `password`= ?
         '); 

    $query->execute(array(
        $_POST['inputEmail'], 
        $_POST['inputPassword']));
    
    $admin = $query->fetch();
    // Réinitialiser le pointer
    $query -> closeCursor();

    if(!empty($admin)){
     
        // $_SESSION['id']= $author['id'];
		// $_SESSION['firstname']= $author['firstname'];
        // $_SESSION['lastname']= $author['lastname'];
		// $_SESSION['email']= $author['email'];
		// $_SESSION['logged']= true;
       
        header('Location: admin_product_index.php');
        exit();
    }else{
        echo "verifier votre cordonnee";
        header('Location: admin_login.php');
        exit();
    }
    
    }
    }












// $template = 'admin_login';
include 'admin_login.phtml';



} catch (PDOException $e) {

die("Impossible de se connecter à la base de données $dbname :" . $e->getMessage());

}

?>