<?php
require_once('model/modelnews.php');
require_once('model/modelbanni.php');

function listeArticle($bdd, $pseudo, $id, $statu, $managernews, $managercomments)
{
    $data = getBanni($bdd, $pseudo, $statu);
    list($ArticleParPage, $depart, $pagesTotales, $pageCourante) = getPage($bdd);
    $articles = $managernews->getList($depart, $ArticleParPage);
    $titre = 'Mon blog';
    ob_start();
    require('view/affichageindex.php');
    $content = ob_get_clean();
    $nbcommentaire = $managercomments->getNBCommentaire((string) $pseudo);
    $nbarticle = $managernews->getNBArticle();
    require('view/template.php');
}

function Article($bdd, $articleID, $pseudo, $id, $statu, $managernews, $managercomments)
{
    $data = getBanni($bdd, $pseudo, $statu);
    $article = $managernews->getUnique((int) $articleID);
    $commentaires = $managercomments->getListUnique((int) $articleID);
    $titre = 'Commentaire';
    ob_start();
    require('view/affichagecommentaires.php');
    $content = ob_get_clean();
    $nbcommentaire = $managercomments->getNBCommentaire((string) $pseudo);
    $nbarticle = $managernews->getNBArticle();
    require('view/template.php');
}

function addCommententaire($bdd, $articleID, $auteur, $postcommentaire , $managercomments)
{
    $com = new Commentaire($id_billet = $articleID, $auteur, $commentaire = $postcommentaire);
    $ligneaffecter = $managercomments->add($com);
    if($ligneaffecter == false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    } else {
        header('Location: index.php?id_billet=' . $articleID . '&action=Article');
    }
}

function delCommentaire($bdd, $commentaireID, $articleID,$managercomments)
{
    $ligneaffecter = $managercomments->delete($articleID);
    if ($ligneaffecter === false) {
        throw new Exception('Impossible de supprimer le commentaire !');
    } else {
        header('Location: index.php?id_billet=' . $articleID . '&action=Article');
    }
}
