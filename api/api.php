<?php
ini_set('display_errors', 1); 
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization, X-Auth-Token');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS'); 

$serveur = "localhost";
  $user = "matera";
  $password ="7FRnb1N1tu5a76fx";
  $name_bdd ="matera";
  $method = $_SERVER['REQUEST_METHOD'];
  $input = file_get_contents('php://input');
  $input = json_decode($input);
try
  {
$connexion= new PDO('mysql:host='.$serveur.';dbname='.$name_bdd.';charset=utf8', $user, $password);
$connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }  
catch(Exception $e)
  {
      die('Erreur :'.$e->getMessage());
  } 
     if ($method == 'GET') {
      $req= $connexion->prepare("SELECT * FROM projets ");
      $req->execute();
      $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
      echo (json_encode($resultat));


  // upload image
} else if ($method == 'POST') { 
   $img= $_FILES["img"]["name"];
   $chemin_img = $_FILES['img']['tmp_name'];
   $chemin = realpath("api.php");
   $chemin = str_replace("api.php","img/", $chemin);
   echo $chemin.$img;
   $img_taille = $_FILES['img']['size'];
   $check = getimagesize($chemin_img);
   $taille_maxi = 250000;
   if($check == true){
    if ($img_taille < $taille_maxi){
      var_dump(move_uploaded_file($chemin_img, $chemin.$img));
    }
   }
   //info projet
   $titre = $_POST['titre'];
   $description = $_POST['description'];
   $url_projet = $_POST['url_projet'];
   $url_github = $_POST['url_github'];
   $participants = $_POST['participants'];
   $date = $_POST['date_projet'];
   $req= $connexion -> prepare('INSERT INTO projets (titre, description, url_projet, url_github, participants, date_projet, img, chemin_img) VALUES (?,?,?,?,?,?,?,?)');
   $req->execute(array($titre, $description, $url_projet, $url_github, $participants, $date, $img, $chemin.$img));
   }
   else if($method == 'DELETE'){
    $titre = $input->infos->titre;
    $req = $connexion -> query("DELETE FROM projets WHERE titre='$titre'");
   }
?>