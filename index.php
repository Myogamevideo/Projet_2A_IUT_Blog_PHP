<?php
require_once('Lib/autoload.php');
$bdd = DBApp::getDatabase();
session_start();
$managernews = new ArticleManagerPDO($bdd);
$managercomments = new CommentaireManagerPDO($bdd);
require_once('controller/controllerindex.php');
$erreurr = array();

if(isset($_SESSION['statu'])){
    $statu = $_SESSION['statu'];
}else{
    $statu = null;
}
if(isset($_SESSION['pseudo'])){
    $pseudo = $_SESSION['pseudo'];
}else{
    $pseudo = null;
}
if(isset($_SESSION['id'])){
    $id = $_SESSION['id'];
}else{
    $id = null;
}
if(isset($_COOKIE['nbcommentaire'])){
    $nbcommentaire = $_COOKIE['nbcommentaire'];
}else{
    $nbcommentaire = 0;
}
if(isset($_COOKIE['pseudo'])){
    $cookiepseudo = $_COOKIE['pseudo'];
}else{
    $cookiepseudo = null;
}
if(isset($_COOKIE['password'])){
    $cookiepassword = $_COOKIE['password'];
}else{
    $cookiepassword = null;
}
if(isset($_COOKIE['statu'])){
    $cookiestatu = $_COOKIE['password'];
}else{
    $cookiestatu = null;
}
if(isset($_POST['commentaire'])){
    $postcommentaire = $_POST['commentaire'];
}
if(isset($_GET['id_billet'])){
    $articleID = $_GET['id_billet'];
}
if(isset($_GET['id_commentaire'])){
    $commentaireID = $_GET['id_commentaire'];
}

try{
    if (isset($_GET['action'])){
        $action = $_REQUEST['action'];
        switch($action){
            case 'listeArticle': 
                listeArticle($bdd,$pseudo,$id,$statu,$managernews,$managercomments);
            break;
            case 'Article':
                if (isset($articleID) && $articleID > 0) {
                    Article($bdd,$articleID,$pseudo,$id,$statu,$managernews,$managercomments);
                }
                else {
                    throw new Exception('Erreur : aucun identifiant de billet envoyé');
                }
            break;
            case 'addCommententaire':
                if (isset($articleID) && $articleID > 0) {
                    if (!empty($pseudo) && !empty($postcommentaire)) {
                        addCommententaire($articleID,$pseudo, $postcommentaire,$managercomments);
                    }
                    else {
                        throw new Exception('Erreur : tous les champs ne sont pas remplis !');
                    }
                }
                else {
                    throw new Exception('Erreur : aucun identifiant de billet envoyé');
                }
            break;
            case 'delCommentaire' :
                delCommentaire($commentaireID,$articleID,$managercomments);
            break;
            default :
                throw new Exception('Erreur : Erreur d\'appel php');
                listeArticle($bdd,$pseudo,$id,$statu,$managernews,$managercomments);
            break;
        }
    }else {
        listeArticle($bdd,$pseudo,$id,$statu,$managernews,$managercomments);
    }
}catch (Exception $e){
    echo $erreurr[] = $e->getMessage();
}

