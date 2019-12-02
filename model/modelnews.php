<?php

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

/*
function postCommentaire($bdd,$articleID,$auteur,$postcommentaire){
    $postcommentaire = preg_replace('#\[b\](.+)\[/b\]#isU', '<strong>$1</strong>', $postcommentaire);
    $postcommentaire = preg_replace('#\[i\](.+)\[/i\]#isU', '<em>$1</em>', $postcommentaire);
    $postcommentaire = preg_replace('#\[color=(red|green|blue|yellow|purple|olive)\](.+)\[/color\]#isU', '<span style="color:$1">$2</span>', $postcommentaire);
    $postcommentaire = preg_replace('#http://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', $postcommentaire);
    $comments = $bdd->prepare('insert into commentaires (id_billet,auteur,commentaire,date_commentaire) values (:id_billet,:auteur,:commentaire,now())');
    $ligneaffecter = $comments->execute(array('id_billet' => $articleID,
    'auteur' => $auteur,
    'commentaire' => $postcommentaire
    ));
    return $ligneaffecter;
}

function suppCommentaire($bdd,$commentaireID,$articleID){
    $delcommentaire = $bdd->prepare('delete from commentaires where id=? and id_billet=?');
    $delcommentaire->execute(array($commentaireID,$articleID));
    return $delcommentaire;
}
*/