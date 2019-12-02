<?php
function getCommentaires($bdd)
{
    $comments = $bdd->query('select C.id, C.id_billet , B.titre , C.auteur , C.commentaire , C.date_commentaire from billets B , commentaires C where C.id_billet=B.id');
    return $comments;
}

function getMembre($bdd)
{
    $membre = $bdd->query('select id, pseudo , email , date_inscription , statu from membres');
    return $membre;
}

function findArticle($bdd, $recherche)
{
    $articles = $bdd->query('SELECT titre FROM billets ORDER BY id DESC');
    if (isset($recherche) and !empty($recherche)) {
        $resultat = htmlspecialchars($recherche);
        $articles = $bdd->query('SELECT titre FROM billets WHERE titre LIKE "%' . $resultat . '%" ORDER BY id DESC');
        if ($articles->rowCount() == 0) {
            $articles = $bdd->query('SELECT titre FROM billets WHERE CONCAT(titre, contenu) LIKE "%' . $resultat . '%" ORDER BY id DESC');
        }
    }
    return $articles;
}

function suppArticle($bdd, $articleID)
{
    $ligneaffecter = $bdd->prepare('delete from billets where id=?');
    $ligneaffecter->execute(array($articleID));
    return $ligneaffecter;
}

function suppCommentaire($bdd, $commentaireID)
{
    $ligneaffecter = $bdd->prepare('delete from commentaires where id=?');
    $ligneaffecter->execute(array($commentaireID));
    return $ligneaffecter;
}

function suppMembre($bdd, $membreID, $getpseudo)
{
    $ligneaffecter1 = $bdd->prepare('delete from commentaires where auteur=?');
    $ligneaffecter1->execute(array($getpseudo));
    $ligneaffecter2 = $bdd->prepare('delete from membres where id=?');
    $ligneaffecter2->execute(array($membreID));
    return array($ligneaffecter1, $ligneaffecter2);
}

function ban($bdd, $membreID, $getpseudo)
{
    $ligneaffecter1 = $bdd->prepare('update membres set statu=\'banni\' where id=?');
    $ligneaffecter1->execute(array($membreID));
    $ligneaffecter2 = $bdd->prepare('delete from commentaires where auteur=?');
    $ligneaffecter2->execute(array($getpseudo));
    return array($ligneaffecter1, $ligneaffecter2);
}

function postNews($bdd, $postcontenu, $posttitre)
{
    $postcontenu = preg_replace('#\[b\](.+)\[/b\]#isU', '<strong>$1</strong>', $postcontenu);
    $postcontenu = preg_replace('#\[i\](.+)\[/i\]#isU', '<em>$1</em>', $postcontenu);
    $postcontenu = preg_replace('#\[color=(red|green|blue|yellow|purple|olive)\](.+)\[/color\]#isU', '<span style="color:$1">$2</span>', $postcontenu);
    $postcontenu = preg_replace('#http://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', $postcontenu);
    $ligneaffecter1 = $bdd->prepare('select count(*) as nbr from billets where titre=?');
    $ligneaffecter1->execute(array($posttitre));
    $donne = $ligneaffecter1->fetch(PDO::FETCH_ASSOC);
    if ($donne['nbr'] != 0) {
        throw new Exception('<strong>Information : </strong> Titre dejà utilisé');
    } else {
        /*
        if(isset($_FILES['fichier'])){
            $content_dir = 'images/';
            $tmp_file = $_FILES['fichier']['tmp_name'];
            if(!is_uploaded_file($tmp_file)){
                echo 'Le fichier est introuvable';
            }
            $type_file = $_FILES['fichier']['type'];
            if(!strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') ){
                echo 'Le fichier n\'est pas une image';
            }
            $name_file = $_FILES['fichier']['name'];
            if(!move_uploaded_file($tmp_file, $content_dir . $name_file)){
                echo 'Impossible de copier le fichier dans '.$content_dir.'';
            }
        }*/
        $ligneaffecter2 = $bdd->prepare('insert into billets (titre,contenu,date_creation) values (:titre,:contenu,now())');
        $ligneaffecter2->execute(array(
            'titre' => $posttitre,
            'contenu' => $postcontenu,
        ));
        return array($ligneaffecter1, $ligneaffecter2);
    }
}

function getArticle($bdd, $articleID)
{
    $article = $bdd->prepare('select * from billets where id=?');
    $article->execute(array($articleID));
    return $article;
}

function modifNews($bdd, $postcontenu, $posttitre, $articleID)
{
    $postcontenu = preg_replace('#\[b\](.+)\[/b\]#isU', '<strong>$1</strong>', $postcontenu);
    $postcontenu = preg_replace('#\[i\](.+)\[/i\]#isU', '<em>$1</em>', $postcontenu);
    $postcontenu = preg_replace('#\[color=(red|green|blue|yellow|purple|olive)\](.+)\[/color\]#isU', '<span style="color:$1">$2</span>', $postcontenu);
    $postcontenu = preg_replace('#http://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', $postcontenu);
    $ligneaffecter1 = $bdd->prepare('select count(*) as nbr from billets where titre=?');
    $ligneaffecter1->execute(array($posttitre));
    $donne = $ligneaffecter1->fetch(PDO::FETCH_ASSOC);
    if ($donne['nbr'] != 0) {
        throw new Exception('<strong>Information : </strong> Titre dejà utilisé');
    } else {
        $ligneaffecter2 = $bdd->prepare('update billets set titre=:titre, contenu=:contenu, date_creation=now() where id="' . $articleID . '"');
        $ligneaffecter2->execute(array(
            'titre' => $posttitre,
            'contenu' => $postcontenu,
        ));
    }
    return array($ligneaffecter1, $ligneaffecter2);
}
