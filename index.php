<?php include('haut.php'); ?>

<?php
$ArticleParPage = 5;
$ArticleTotalesReq = $bdd->query('SELECT id FROM billets');
$ArticleTotales = $ArticleTotalesReq->rowCount();
$pagesTotales = ceil($ArticleTotales/$ArticleParPage);
if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $pagesTotales) {
    $_GET['page'] = intval($_GET['page']);
    $pageCourante = $_GET['page'];
}else{
    $pageCourante = 1;
}
$depart = ($pageCourante-1)*$ArticleParPage;
?>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5"> Actualités :</h1>
        <div class="blog-post">
            <?php 
                $reponse = $bdd->query('select id,contenu,titre, DAY(date_creation) AS jour, MONTH(date_creation) AS mois, YEAR(date_creation) AS annee, HOUR(date_creation) AS heure, MINUTE(date_creation) AS minute, SECOND(date_creation) AS seconde from billets order by date_creation limit '.$depart.','.$ArticleParPage);
                while($donnees = $reponse->fetch()){
                    echo '<a style="text-decoration:none;" class="reinitialise" href="commentaires.php?id_billet='.$donnees['id'].'">';
                    echo '<div>';
                    echo '<h2 class="blog-post-title">'.$donnees['titre'].'</h2>';
                    echo '<p class="blog-post-meta">Le '.$donnees['jour'].'/'.$donnees['mois'].'/'.$donnees['annee'].' à '.$donnees['heure'].'h'.$donnees['minute'].'</p>';
                    echo '<p 
                    style="max-height: 2em;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: nowrap;">'.$donnees['contenu'].'</p>';
                    echo '</div>';
                    echo '</a>';
                }
                $reponse->closeCursor();
            ?>
        </div>

        <?php
        for($i=1;$i<=$pagesTotales;$i++) {
            if($i == $pageCourante) {
                echo '<button>'.$i.'</button>';
            } else {
                echo '<a href="index.php?page='.$i.'"><button>'.$i.'</button></a> ';
            }
        }
        ?>
        
    </div>
</main>
<?php include('bas.php'); ?>
