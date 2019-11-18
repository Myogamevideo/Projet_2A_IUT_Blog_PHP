<?php
$user_nbr=1;

$req = $bdd->query('select count(id) as nb from billets');
$nbarticle = $req->fetch();
?>


<footer class="footer mt-auto py-3">
    <div class="container">
    <?php
    $date = date("d-m-Y");
    $heure = date("H:i");
    if (isset($_SESSION['id']) AND isset($_SESSION['pseudo'])){
        echo '<span class="text-muted">Bonjour '.$_SESSION['pseudo'].' -- Nous sommes le '.$date.' et il est '.$heure.' -- Il y a '.$nbarticle['nb'].' articles publié -- Vous avez partagé votre avis : '.$_COOKIE['nbcommentaire'].' fois</span>';
    }else{
        echo '<span class="text-muted">Nous sommes le '.$date.' et il est '.$heure.' -- Il y a '.$nbarticle['nb'].' articles publié</span>';
    }
    ?>
    </div>
</footer>
</body>
</html>
