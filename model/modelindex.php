<?php
class ModeleIndex{
    public function listeArticle($bdd,$pseudo,$statu)
    {
        $managernews = new ArticleManagerPDO($bdd);
        $managercomments = new CommentaireManagerPDO($bdd);
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

    public function Article($articleID,$pseudo,$statu,$bdd)
    {
        $managernews = new ArticleManagerPDO($bdd);
        $managercomments = new CommentaireManagerPDO($bdd);
        $article = $managernews->getUnique((int) $articleID);
        $commentaires = $managercomments->getListCommentaireByBillet((int) $articleID);
        $titre = 'Commentaire';
        ob_start();
        require('view/affichagecommentaires.php');
        $content = ob_get_clean();
        $nbcommentaire = $managercomments->getNBCommentaire((string) $pseudo);
        $nbarticle = $managernews->getNBArticle();
        require('view/template.php');
    }

    public function addCommententaire($articleID,$pseudo, $postcommentaire,$bdd)
    {
        $managercomments = new CommentaireManagerPDO($bdd);
        $com = new Commentaire(['id_billet' => $articleID, 'auteur' => $pseudo, 'commentaire' => $postcommentaire]);
        $ligneaffecter = $managercomments->add($com);
        if($ligneaffecter == false) {
            throw new Exception('Impossible d\'ajouter le commentaire !');
        } else {
            header('Location: index.php?id_billet=' . $articleID . '&action=Article');
        }
    }

    public function delCommentaire($commentaireID, $articleID,$bdd)
    {
        $managercomments = new CommentaireManagerPDO($bdd);
        $ligneaffecter = $managercomments->delete($commentaireID);
        if ($ligneaffecter == false) {
            throw new Exception('Impossible de supprimer le commentaire !');
        } else {
            header('Location: index.php?id_billet=' . $articleID . '&action=Article');
        }
    }
}

function getPage($bdd){
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
    return array($ArticleParPage,$depart,$pagesTotales,$pageCourante);
}


