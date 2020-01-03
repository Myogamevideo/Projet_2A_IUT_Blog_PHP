<main role="main" class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5"> Actualités :</h1>
        <?php
        echo '<h2 class="blog-post-title">' . $article->gettitre() . '</h2>';
        echo '<p class="blog-post-meta">Paru le ' . $article->getdate_creation() . '</p>';
        echo '<p>' . nl2br($article->getcontenu()) . '</p>';?>
        <h3> Ajouter un commentaire :</h3>
        <?php
        if (isset($pseudo) and $pseudo != NULL) {
            ?>
            <?php echo '<form method="POST" action="index.php?id_billet=' . $articleID . '&action=addCommententaire" class="class="form-signin">'; ?>
            <label for="auteur" class="sr-only">Auteur : </label><input type="text" name="auteur" id="auteur" disabled="disabled" value="<?php echo $pseudo; ?>" class="form-control" />
            <button type="button" class="btn btn-primary" disabled="disabled"><strong>[b] Texte en gras [/b]</strong></button>
            <button type="button" class="btn btn-secondary" disabled="disabled"><em>[i] Texte en italique [/i]</em></button>
            <button type="button" class="btn btn-warning" disabled="disabled"><span style="color:red">[color=red] Texte en rouge [/color]</span></button>
            <button type="button" class="btn btn-link" disabled="disabled"><a href="">Lien : http://...</a></button>
            <label for="commentaire" class="sr-only">Commentaire : </label><textarea name="commentaire" id="commentaire" rows="4" cols="10" style="resize:none;" wrap="hard" class="form-control" placeholder="Commentaire (max 500 caractére)" maxlength="500"></textarea>
            <button type="submit" class="btn btn-lg btn-primary btn-block">Publier</button>
            </form>
        <?php
        } else {
            echo '<p class="text-muted"> Veuillez vous inscire ou vous connectez pour mettre un commentaire</p>';
        }
        ?>
        <h3>Commentaires :</h3>
        <?php
        echo '<div>';
        foreach ($commentaires as $comments) {
            echo 'De <span style="color:blue">' . $comments->getauteur() . '</span> le ' . $comments->getdate_commentaire();
            echo '<div> <em>' . $comments->getcommentaire() . '</em></div>';
            if (isset($pseudo) and $pseudo == $comments->getauteur()) {
                echo '<form method="POST" action="index.php?id_commentaire=' . $comments->getid() . '&amp;id_billet=' . $articleID . '&amp;action=delCommentaire">';
                echo '<button type="submit" class="btn btn-lg btn-primary btn-block"> Supprimer votre commentaire </button> ';
                echo '</form>';
                echo '</div>';
            }
        }
        ?>
    </div>
</main>