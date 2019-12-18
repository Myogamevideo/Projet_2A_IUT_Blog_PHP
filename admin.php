<?php
require_once('Lib/autoload.php');
$bdd = DBApp::getDatabase();
session_start();
$managernews = new ArticleManagerPDO($bdd);
$managercomments = new CommentaireManagerPDO($bdd);
$managermembre = new MembreManagerPDO($bdd);
require_once('controller/controlleradmin.php');
$erreurr = array();

if(isset($_POST['recherche'])){
    $recherche = $_POST['recherche'];
}else{
    $recherche = null;
}

if (isset($_SESSION['statu'])) {
    $statu = $_SESSION['statu'];
} else {
    $statu = null;
}
if (isset($_SESSION['pseudo'])) {
    $pseudo = $_SESSION['pseudo'];
} else {
    $pseudo = null;
}
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
} else {
    $id = null;
}
if (isset($_COOKIE['nbcommentaire'])) {
    $nbcommentaire = $_COOKIE['nbcommentaire'];
} else {
    $nbcommentaire = 0;
}
if (isset($_COOKIE['pseudo'])) {
    $cookiepseudo = $_COOKIE['pseudo'];
} else {
    $cookiepseudo = null;
}
if (isset($_COOKIE['password'])) {
    $cookiepassword = $_COOKIE['password'];
} else {
    $cookiepassword = null;
}
if (isset($_COOKIE['statu'])) {
    $cookiestatu = $_COOKIE['password'];
} else {
    $cookiestatu = null;
}
if (isset($_POST['commentaire'])) {
    $postcommentaire = $_POST['commentaire'];
}
if (isset($_GET['id_billet'])) {
    $articleID = $_GET['id_billet'];
}
if (isset($_GET['id_commentaire'])) {
    $commentaireID = $_GET['id_commentaire'];
}

try {
    if (isset($_GET['action'])) {
        $action = $_REQUEST['action'];
        switch ($action) {
            case 'admin':
                PageAdmin($bdd, $pseudo, $statu, $recherche,$managernews,$managercomments,$managermembre);
                break;
            case 'delArticle':
                if (isset($articleID)) {
                    delArticle($articleID,$managernews);
                } else {
                    PageAdmin($bdd, $pseudo, $statu, $recherche,$managernews,$managercomments);
                }
                break;
            case 'delCommentaire':
                if (isset($commentaireID)) {
                    delCommentaire($commentaireID,$managercomments);
                } else {
                    PageAdmin($bdd, $pseudo, $statu, $recherche,$managernews,$managercomments,$managermembre);
                }
                break;
            case 'delMembre':
                if (isset($membreID) and isset($getpseudo)) {
                    delMembre($membreID, $getpseudo, $managermembre , $managercomments );
                } else {
                    PageAdmin($bdd, $pseudo, $statu, $recherche,$managernews,$managercomments,$managermembre);
                }
                break;
            case 'bannirMembre':
                if (isset($membreID) and isset($getpseudo)) {
                    Bannir($membreID, $getpseudo,$managernews,$managercomments);
                } else {
                    PageAdmin($bdd, $pseudo, $statu, $recherche,$managernews,$managercomments,$managermembre);
                }
                break;
            case 'ajouterNews':
                if (isset($postcontenu) and isset($posttitre) and $postcontenu != NULL and $posttitre != NULL) {
                    addNews($bdd, $postcontenu, $posttitre);
                } else {
                    PageajouterNews($bdd, $pseudo, $statu,$managernews,$managercomments);
                    throw new Exception('<strong>Information : </strong> Un ou plusieurs champs sont vide');
                }
                break;
            case 'modifierNews':
                if (isset($postcontenu) and isset($posttitre) and $postcontenu != NULL and $posttitre != NULL) {
                    modifyNews($bdd, $postcontenu, $posttitre, $articleID);
                } else {
                    PagemodifyNews($bdd, $pseudo, $statu, $articleID,$managernews,$managercomments);
                    throw new Exception('<strong>Information : </strong> Un ou plusieurs champs sont vide');
                }
                break;
            default:
                throw new Exception('Erreur : Erreur d\'appel php');
                header('location: index.php');
                break;
        }
    } else {
        header('location: index.php');
    }
} catch (Exception $e) {
    echo $erreurr[] = $e->getMessage();
}
