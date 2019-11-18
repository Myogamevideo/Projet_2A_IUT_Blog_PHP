<?php
try{
    $bdd = new PDO('mysql:host=localhost;dbname=blog_project;charset=utf8','root','');
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
}catch(Exception $e){
    die('Erreur :'.$e->getMessage());
}
session_start();
?>

<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
  <title>Blog</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body class="d-flex flex-column h-100">
<main role="main" class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5"> ⚠️ VOUS AVEZ ETE DU BLOG ⚠️ :</h1>
        <div class="alert alert-danger">
            <div>
                ---------------
                <?php
                echo $_SESSION['pseudo'];
                ?>
                ---------------
            </div>
            <strong>Motif : </strong> commentaire malveillant 
            </h2>
        </div>
        <a class="btn btn-sm btn-outline-secondary" href="deconnexion.php">Deconnexion</a>
    </div>
</main>
</body>
</html>
