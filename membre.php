<?php
require_once('lib/autoload.php');
$bdd = DBApp::getDatabase();
$managercomments = new CommentaireManagerPDO($bdd);
$managermembre = new MembreManagerPDO($bdd);
$managernews = new ArticleManagerPDO($bdd);
require_once('controller/controllermembre.php');
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
if(isset($_POST['pseudo'])){
    $postpseudo = $_POST['pseudo'];
}
if(isset($_POST['password'])){
    $postpassword = $_POST['password'];
}
if(isset($_POST['case'])){
    $postcase = $_POST['case'];
}else{
    $postcase = null;
}
if(isset($_POST['confi_password'])){
    $postconfig_password = $_POST['confi_password'];
}
if(isset($_POST['email'])){
    $postemail = $_POST['email'];
}
if(isset($_GET['id_commentaire'])){
    $commentaireID = $_GET['id_commentaire'];
}

try{
    if (isset($_GET['action'])){
        $action = $_REQUEST['action'];
        switch($action){
            case 'connexion':
                if(isset($postpseudo) and isset($postpassword)){
                    Connexion($bdd,$id,$pseudo,$statu,$postpseudo,$postpassword,$postcase,$cookiepseudo,$cookiepassword,$cookiestatu, $managernews, $managercomments);
                }else{
                    PageConnexion($bdd,$pseudo,$id,$statu, $managernews, $managercomments);
                }
            break;
            case 'inscription':
                if(isset($postpseudo) and isset($postpassword) and isset($postconfig_password) and isset($postemail)){
                    Inscription($bdd,$pseudo,$id,$statu,$postpseudo,$postpassword,$postconfig_password,$postemail, $managernews, $managercomments);
                }else{
                    PageInscription($bdd,$pseudo,$id,$statu, $managernews, $managercomments);
                }
            break;
            case 'deconnexion' :
                Deconnexion($bdd);
            break;
            case 'profil':
                if(isset($postpseudo) and isset($postemail)){
                    ModifierProfil($bdd,$pseudo,$statu,$postpseudo,$postemail, $managernews, $managercomments);
                }elseif(isset($commentaireID)){
                    delCommentaire($bdd,$commentaireID,$managercomments, $managernews, $managercomments);
                }else{
                    PageProfil($bdd,$pseudo,$statu,$managercomments, $managernews, $managercomments);
                }
            break;
            default:
                throw new Exception('Erreur : Erreur d\'appel php');
                header('location: index.php');
            break;
        }
    }else {
        header('location: index.php');
    }
}catch(Exception $e){
    echo $erreurr[] = $e->getMessage();
}

