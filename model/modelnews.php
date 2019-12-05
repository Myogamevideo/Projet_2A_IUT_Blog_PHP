<?php
function getBanni($bdd, $pseudo, $statu)
{
    if (isset($statu) and $statu == 'banni') {
        header('location: affichagebanni.php');
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
