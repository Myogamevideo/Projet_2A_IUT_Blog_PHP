<?php
function getBanni($statu)
{
    if (isset($statu) and $statu == 'banni') {
        header('location: affichagebanni.php');
    }
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
