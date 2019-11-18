<?php
try{
    $bdd = new PDO('mysql:host=localhost;dbname=blog_project;charset=utf8','root','');
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
}catch(Exception $e){
    die('Erreur :'.$e->getMessage());
}
session_start();

if(isset($_SESSION['status']) and $_SESSION['status'] == 'banni'){
    header('location: banni.php');
}
if(isset($_SESSION['pseudo'])){
    $reponse = $bdd->prepare('select count(*) as nbcommentaire from commentaires where auteur=?');
    $reponse->execute(array($_SESSION['pseudo']));
    $data = $reponse->fetch();
    setcookie('nbcommentaire',$data['nbcommentaire'],time()+3600,null,null,false,true);
}
?>

<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
  <title>Blog</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="style.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body class="d-flex flex-column h-100">
    <header class="blog-header py-3">
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="#">Blog</a>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="inscription.php">Inscription</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="connexion.php">Connexion</a>
                    </li>
                        <?php 
                        if(isset($_SESSION['pseudo']) and $_SESSION['pseudo'] != NULL){
                            echo '<a class="nav-link" href="deconnexion.php">Deconnexion</a>';
                        }else{
                            echo '<a class="nav-link disabled" href="deconnexion.php" tabindex="-1" aria-disabled="true">Deconnexion</a>';
                        }
                        ?>
                    </li> 
                </ul>
                <div class="col-4 d-flex justify-content-end align-items-center">
                <?php 
                if(isset($_SESSION['status']) and $_SESSION['status'] == 'admin'){
                    echo '<a class="btn btn-sm btn-outline-secondary" href="profil.php">Profil</a>';
                    echo '<a class="btn btn-sm btn-outline-secondary" href="admin.php">Page administration</a>';
                }elseif(isset($_SESSION['status'])){
                    echo '<a class="btn btn-sm btn-outline-secondary" href="profil.php">Profil</a>';
                }
                ?>  
                </div>
            </div>
        </nav>
    </header>