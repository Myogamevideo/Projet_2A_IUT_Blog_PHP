<?php
require_once('model/modeladmin.php');
require_once('model/modelhautbas.php');
require_once('model/modelbanni.php');

function PageAdmin($bdd, $pseudo, $statu, $recherche)
{
    $data = getBanni($bdd, $pseudo, $statu);
    $titre = 'Admin';
    $comments = getCommentaires($bdd);
    $membre = getMembre($bdd);
    $articles = findArticle($bdd, $recherche);
    ob_start();
    require('view/affichageadmin.php');
    $content = ob_get_clean();
    $nbcommentaire = getNBCommentaire($bdd, $pseudo);
    $nbarticle = getNBArticle($bdd);
    require('view/template.php');
}

function delArticle($bdd, $articleID)
{
    $ligneaffecter = suppArticle($bdd, $articleID);
    if ($ligneaffecter == false) {
        throw new Exception('Impossible de supprimer l\'article !');
    } else {
        header('Location: admin.php?action=admin');
    }
}

function delCommentaire($bdd, $commentaireID)
{
    $ligneaffecter = suppCommentaire($bdd, $commentaireID);
    if ($ligneaffecter == false) {
        throw new Exception('Impossible de supprimer le commentaire !');
    } else {
        header('Location: admin.php?action=admin');
    }
}

function delMembre($bdd, $membreID, $getpseudo)
{
    list($ligneaffecter1, $ligneaffecter2) = suppMembre($bdd, $membreID, $getpseudo);
    if ($ligneaffecter1 == false or $ligneaffecter2 == false) {
        throw new Exception('Impossible de supprimer le membre !');
    } else {
        header('Location: admin.php?action=admin');
    }
}

function Bannir($bdd, $membreID, $getpseudo)
{
    list($ligneaffecter1, $ligneaffecter2) = ban($bdd, $membreID, $getpseudo);
    if ($ligneaffecter1 == false or $ligneaffecter2 == false) {
        throw new Exception('Impossible de bannir le membre !');
    } else {
        header('Location: admin.php?action=admin');
    }
}

function PageajouterNews($bdd, $pseudo, $statu)
{
    $data = getBanni($bdd, $pseudo, $statu);
    $titre = 'Ajouter article';
    ob_start();
    require('view/affichageajouternews.php');
    $content = ob_get_clean();
    $nbcommentaire = getNBCommentaire($bdd, $pseudo);
    $nbarticle = getNBArticle($bdd);
    require('view/template.php');
}

function addNews($bdd, $postcontenu, $posttitre)
{
    list($ligneaffecter1, $ligneaffecter2) = postNews($bdd, $postcontenu, $posttitre);
    if ($ligneaffecter1 == false or $ligneaffecter2 == false) {
        throw new Exception('Impossible d\'ajouter l\'article !');
    } else {
        header('Location: admin.php?action=admin');
    }
}

function PagemodifyNews($bdd, $pseudo, $statu, $articleID)
{
    $data = getBanni($bdd, $pseudo, $statu);
    $titre = 'Modifier article';
    $article = getArticle($bdd, $articleID);
    ob_start();
    require('view/affichagemodifiernews.php');
    $content = ob_get_clean();
    $nbcommentaire = getNBCommentaire($bdd, $pseudo);
    $nbarticle = getNBArticle($bdd);
    require('view/template.php');
}

function modifyNews($bdd, $postcontenu, $posttitre, $articleID)
{
    list($ligneaffecter1, $ligneaffecter2) = modifNews($bdd, $postcontenu, $posttitre, $articleID);
    if ($ligneaffecter1 == false or $ligneaffecter2 == false) {
        throw new Exception('Impossible d\'ajouter l\'article !');
    } else {
        header('Location: admin.php?action=admin');
    }
}
