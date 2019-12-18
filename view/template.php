<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title><?= $titre ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="public/css/style.css" rel="stylesheet" type="text/css">
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
                        <a class="nav-link" href="membre.php?action=inscription">Inscription</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="membre.php?action=connexion">Connexion</a>
                    </li>
                    <?php
                    if (isset($pseudo) and $pseudo != NULL) {
                        echo '<a class="nav-link" href="membre.php?action=deconnexion">Deconnexion</a>';
                    } else {
                        echo '<a class="nav-link disabled" href="membre.php?action=deconnexion" tabindex="-1" aria-disabled="true">Deconnexion</a>';
                    }
                    ?>
                    </li>
                </ul>
                <div class="col-4 d-flex justify-content-end align-items-center">
                    <?php
                    if (isset($statu) and $statu == 'admin') {
                        echo '<a class="btn btn-sm btn-outline-secondary" href="membre.php?action=profil">Profil</a>';
                        echo '<a class="btn btn-sm btn-outline-secondary" href="admin.php?action=admin">Page administration</a>';
                    } elseif (isset($statu)) {
                        echo '<a class="btn btn-sm btn-outline-secondary" href="profil.php">Profil</a>';
                    }
                    ?>
                </div>
            </div>
        </nav>
    </header>
    <body>
        <?php 
        if(!empty($erreurr)){
            echo '<div class="alert alert-danger">';
            foreach($erreurr as $error){
                echo '<p>'.$error.'</p>';
            }
            echo '</div>';
        }
        ?>
        
        <?= $content ?>
    </body>
    <footer class="footer mt-auto py-3">
        <div class="container">
            <?php
            $date = date("d-m-Y");
            $heure = date("H:i");
            if (isset($id)) {
                echo '<span class="text-muted">Bonjour ' . $pseudo . ' -- Nous sommes le ' . $date . ' et il est ' . $heure . ' -- Il y a ' . $nbarticle['nb'] . ' articles publié -- Vous avez partagé votre avis : ' . $nbcommentaire['nbcommentaire'] . ' fois</span>';
            } else {
                echo '<span class="text-muted">Nous sommes le ' . $date . ' et il est ' . $heure . ' -- Il y a ' . $nbarticle['nb'] . ' articles publié</span>';
            }
            ?>
        </div>
    </footer>
</body>
<?php

?>
</html>

</html>