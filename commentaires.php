<?php include("haut.php"); ?>
<main role="main" class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5"> Actualités :</h1>
        <?php 
            $req = $bdd->prepare('select id,contenu,titre, DAY(date_creation) AS jour, MONTH(date_creation) AS mois, YEAR(date_creation) AS annee, HOUR(date_creation) AS heure, MINUTE(date_creation) AS minute, SECOND(date_creation) AS seconde from billets where id=?');
            $req->execute(array($_GET['id_billet']));
            $donnees=$req->fetch();
            echo '<h2 class="blog-post-title">'.$donnees['titre'].'</h2>';
            echo '<p class="blog-post-meta">Paru le '.$donnees['jour'].'/'.$donnees['mois'].'/'.$donnees['annee'].' à '.$donnees['heure'].'h'.$donnees['minute'].'</p>';
            echo '<p>'.$donnees['contenu'].'</p>';                
            $req->closeCursor();
        ?>
        <h3> Ajouter un commentaire :</h3>
        <?php 
            if(isset($_SESSION['pseudo']) and $_SESSION['pseudo'] != NULL){
                ?>
                <?php echo '<form method="POST" action="commentaires.php?id_billet='.$_GET['id_billet'].'" class="class="form-signin">'; ?>
                <label for="auteur" class="sr-only">Auteur : </label><input type="text" name="auteur" id="auteur" disabled="disabled" value="<?php echo $_SESSION['pseudo']; ?>" class="form-control"/>
                <label for="commentaire" class="sr-only">Commentaire : </label><textarea name="commentaire" id="commentaire" rows="4" cols="10" style="resize:none;" wrap="hard" class="form-control" placeholder="Commentaire (max 500 caractére)" required="" maxlength="500"></textarea>
                <button type="submit" class="btn btn-lg btn-primary btn-block">Publier</button>
                </form>

                <div class="alert alert-warning">
                    <?php
                    if(isset($_POST['commentaire']) && $_POST['commentaire']!=NULL){
                        $req = $bdd->prepare('insert into commentaires (id_billet,auteur,commentaire,date_commentaire) values (:id_billet,:auteur,:commentaire,now())');
                        $req->execute(array('id_billet' => $_GET['id_billet'],
                        'auteur' => $_SESSION['pseudo'],
                        'commentaire' => $_POST['commentaire']
                        ));
                        $req->closeCursor();
                    }else{
                        echo '<strong>Information : </strong> Un ou plusieurs champs sont vide';
                    }
                    ?>
                </div>
                <?php
            }else{
                echo '<p class="text-muted"> Veuillez vous inscire ou vous connectez pour mettre un commentaire</p>';
            }
        ?>
        <h3>Commentaires :</h3>
        <?php
            echo '<div>';
            $req = $bdd->prepare('select id,commentaire,auteur, DAY(date_commentaire) AS jour, MONTH(date_commentaire) AS mois, YEAR(date_commentaire) AS annee, HOUR(date_commentaire) AS heure, MINUTE(date_commentaire) AS minute, SECOND(date_commentaire) AS seconde from commentaires where id_billet=?');
            $req->execute(array($_GET['id_billet']));
            while($donnees=$req->fetch()){
                echo 'De <span style="color:blue">'.$donnees['auteur'].'</span> le '.$donnees['jour'].'/'.$donnees['mois'].'/'.$donnees['annee'].' à '.$donnees['heure'].'h'.$donnees['minute'].'min'.$donnees['seconde'].'sec -- <a href="like.php?id='.$donnees['id'].'&id_billet='.$_GET['id_billet'].'">J\'aime</a>'; 
                $res = $bdd->prepare('select count(id) likes from like where id_commentaires=?');
                $res->execute(array($donnees['id']));
                $data=$res->fetch();
                echo ' ( '.$data['likes'].' )';
                echo '<div> <em>'.$donnees['commentaire'].'</em></div>';
                if(isset($_SESSION['pseudo']) and $_SESSION['pseudo'] == $donnees['auteur']){ 
                    echo '<form method="POST" action="deletecommentaires_copy.php?id='.$donnees['id'].'&amp;id_billet='.$_GET['id_billet'].'">';            
                    echo '<button type="submit" class="btn btn-lg btn-primary btn-block"> Supprimer votre commentaire </button> ';
                    echo '</form>';
                    echo '</div>';
                }
            }
            $req->closeCursor();
        ?>
    </div>
</main>
<?php include("bas.php"); ?>