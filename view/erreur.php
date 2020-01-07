<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Erreur</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/erreur.css">
</head>

<body>
    <div class="containerErreur">
        <h2>Oouups! Erreur !!!.</h2>
        <?php
        if (isset($erreurr)){
            foreach($erreurr as $val){
                echo $val;
            }
        }
        ?>
        <a href="index.php">Retour à la page d'accueil</a>
    </div>
</body>

</html>