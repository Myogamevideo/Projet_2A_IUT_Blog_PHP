<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Erreur</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/erreur.css">
</head>

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
            <a class="navbar-brand" href="#">Erreur</a>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=pageinscription">Inscription</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=pageconnexion">Connexion</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <body>
        <main role="main" class="flex-shrink-0">
            <div class="container">
                <h1 class="mt-5"> Error !!! :</h1>
                <?php if (!empty($erreurr)) {
                    echo '<div class="alert alert-danger">';
                    foreach ($erreurr as $error) {
                        echo '<p>' . $error . '</p>';
                    }
                    echo '</div>';
                } ?>
            </div>
        </main>
    </body>
    <footer class="footer mt-auto py-3">
        <div class="container">
            <?php
            $date = date("d-m-Y");
            $heure = date("H:i");
            echo '<span class="text-muted">Nous sommes le ' . $date . ' et il est ' . $heure . '</span>';
            ?>
        </div>
    </footer>

</html>