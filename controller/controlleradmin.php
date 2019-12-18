<?php
require_once('model/modeladmin.php');

function PageAdmin($bdd, $pseudo, $statu, $recherche,$managernews,$managercomments,$managermembre)
{
    getBanni($statu);
    $titre = 'Admin';
    $comments = $managercomments->getList();
    $membre = $managermembre->getList();
    $news = $managernews->findArticle($recherche);
    $listearticle = $managernews->getListByTitre($news);
    ob_start();
    require('view/affichageadmin.php');
    $content = ob_get_clean();
    $nbcommentaire = $managercomments->getNBCommentaire((string) $pseudo);
    $nbarticle = $managernews->getNBArticle();
    require('view/template.php');
}


function delArticle($articleID, $managernews)
{
    $ligneaffecter = $managernews->delete($articleID);
    if ($ligneaffecter == false) {
        throw new Exception('Impossible de supprimer l\'article !');
    } else {
        header('Location: admin.php?action=admin');
    }
}

function delCommentaire($commentaireID, $managercomments)
{
    $ligneaffecter = $managercomments->delete($commentaireID);
    if ($ligneaffecter == false) {
        throw new Exception('Impossible de supprimer le commentaire !');
    } else {
        header('Location: admin.php?action=admin');
    }
}

function delMembre($membreID, $getpseudo, $managermembre, $managercomments)
{
    $ligneaffecter1 = $managermembre->delete($membreID);
    $ligneaffecter2 = $managercomments->delete($getpseudo);
    if ($ligneaffecter1 == false or $ligneaffecter2 == false) {
        throw new Exception('Impossible de supprimer le membre !');
    } else {
        header('Location: admin.php?action=admin');
    }
}

function Bannir($membreID, $getpseudo, $managermembre, $managercomments)
{
    $membre = $managermembre->getUnique($membreID);
    $membre->setstatu('banni');
    $ligneaffecter1 = $managermembre->update($membre);
    $ligneaffecter2 = $managercomments->delete($getpseudo);
    if ($ligneaffecter1 == false or $ligneaffecter2 == false) {
        throw new Exception('Impossible de bannir le membre !');
    } else {
        header('Location: admin.php?action=admin');
    }
}

function PageajouterNews($bdd, $pseudo, $statu)
{
    getBanni($statu);
    $titre = 'Ajouter article';
    ob_start();
    require('view/affichageajouternews.php');
    $content = ob_get_clean();
    $nbcommentaire = $managercomments->getNBCommentaire((string) $pseudo);
    $nbarticle = $managernews->getNBArticle();
    require('view/template.php');
}
/*
function addNews($bdd, $postcontenu, $posttitre, $managernews)
{
    $ligneaffecter1 = $managernews->getUnique($posttitre);
    if ($ligneaffecter1 != false) {
        throw new Exception('<strong>Information : </strong> Titre dejà utilisé');
    } else {
        $article = new Article($postcontenu,$posttitre);
        $ligneaffecter2 = $managernews->add($article)
        list($ligneaffecter1, $ligneaffecter2) = postNews($bdd, $postcontenu, $posttitre);
        if ($ligneaffecter2 == false) {
            throw new Exception('Impossible d\'ajouter l\'article !');
        } else {
            header('Location: admin.php?action=admin');
        }
    }
}
*/
function PagemodifyNews($bdd, $pseudo, $statu, $articleID)
{
    $data = getBanni($statu);
    $titre = 'Modifier article';
    $article = getArticle($bdd, $articleID);
    ob_start();
    require('view/affichagemodifiernews.php');
    $content = ob_get_clean();
    $nbcommentaire = $managercomments->getNBCommentaire((string) $pseudo);
    $nbarticle = $managernews->getNBArticle();
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
