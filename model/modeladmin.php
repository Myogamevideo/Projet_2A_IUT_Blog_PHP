<?php
class ModeleAdmin{
    public function PageAdmin($pseudo,$recherche,$statu,$bdd)
    {
        $managernews = new ArticleManagerPDO($bdd);
        $managercomments = new CommentaireManagerPDO($bdd);
        $managermembre = new MembreManagerPDO($bdd);
        $titre = 'Admin';
        $comments = $managercomments->getList();
        $membre = $managermembre->getList();
        $news = $managernews->findArticle((string)$recherche);
        $listearticle = $managernews->getListByTitre($news);
        ob_start();
        require('view/affichageadmin.php');
        $content = ob_get_clean();
        $nbcommentaire = $managercomments->getNBCommentaire((string) $pseudo);
        $nbarticle = $managernews->getNBArticle();
        require('view/template.php');
    }
    
    
    public function delArticle($articleID, $bdd)
    {
        $managernews = new ArticleManagerPDO($bdd);
        $ligneaffecter = $managernews->delete((int)$articleID);
        if ($ligneaffecter == false) {
            throw new Exception('Impossible de supprimer l\'article !');
        } else {
            header('Location: index.php?action=admin');
        }
    }
    
    public function delCommentaire($commentaireID, $bdd)
    {
        $managercomments = new CommentaireManagerPDO($bdd);
        $ligneaffecter = $managercomments->delete((int)$commentaireID);
        if ($ligneaffecter == false) {
            throw new Exception('Impossible de supprimer le commentaire !');
        } else {
            header('Location: index.php?action=admin');
        }
    }
    
    public function delMembre($membreID, $getpseudo, $bdd)
    {
        $managercomments = new CommentaireManagerPDO($bdd);
        $managermembre = new MembreManagerPDO($bdd);
        $ligneaffecter1 = $managermembre->delete((int)$membreID);
        $ligneaffecter2 = $managercomments->delete((string)$getpseudo);
        if ($ligneaffecter1 == false or $ligneaffecter2 == false) {
            throw new Exception('Impossible de supprimer le membre !');
        } else {
            header('Location: index.php?action=admin');
        }
    }
    
    
    public function PageajouterNews($pseudo,$statu, $bdd)
    {
        $managernews = new ArticleManagerPDO($bdd);
        $managercomments = new CommentaireManagerPDO($bdd);
        $titre = 'Ajouter article';
        ob_start();
        require('view/affichageajouternews.php');
        $content = ob_get_clean();
        $nbcommentaire = $managercomments->getNBCommentaire((string) $pseudo);
        $nbarticle = $managernews->getNBArticle();
        require('view/template.php');
    }
    
    public function addNews($postcontenu, $posttitre, $bdd)
    {
        $managernews = new ArticleManagerPDO($bdd);
        $ligneaffecter = $managernews->postNews($postcontenu, (string)$posttitre);
        if($ligneaffecter == false) {
            throw new Exception('Impossible d\'ajouter l\'article !');
        } else {
            header('Location: index.php?action=admin');
        }
    }
    
    public function PagemodifyNews($pseudo,$articleID,$statu,$bdd)
    {
        $managernews = new ArticleManagerPDO($bdd);
        $managercomments = new CommentaireManagerPDO($bdd);
        $titre = 'Modifier article';
        $article =  $managernews->getUnique((int)$articleID);
        ob_start();
        require('view/affichagemodifiernews.php');
        $content = ob_get_clean();
        $nbcommentaire = $managercomments->getNBCommentaire((string) $pseudo);
        $nbarticle = $managernews->getNBArticle();
        require('view/template.php');
    }
    
    public function modifyNews($postcontenu, $posttitre, $articleID , $bdd)
    {
        $managernews = new ArticleManagerPDO($bdd);
        $ligneaffecter = $managernews->modifNews($postcontenu, (string)$posttitre, (int)$articleID);
        if ($ligneaffecter == false) {
            throw new Exception('Impossible de modifier l\'article !');
        } else {
            header('Location: index.php?action=admin');
        }
    }
}


