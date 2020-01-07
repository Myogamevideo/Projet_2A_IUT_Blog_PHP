<?php
require_once('model/modeladmin.php');

class Admin
{
    function __construct($bdd,$erreurr)
    {
        try {
            if (isset($_GET['action'])) {
                $action = $_REQUEST['action'];
                switch ($action) {
                    case 'admin':
                        PageAdmin($bdd);
                        break;
                    case 'delArticle':
                        delArticle($bdd, $erreurr);
                        break;
                    case 'delCommentaireAdmin':
                        delCommentaireAdmin($bdd, $erreurr);
                        break;
                    case 'delMembre':
                        delMembre($bdd, $erreurr);
                        break;
                    case 'ajouterNews':
                        addNews($bdd, $erreurr);
                        break;
                    case 'modifierNews':
                        modifyNews($bdd, $erreurr);
                        break;
                    case 'pagemodifiernews':
                        PagemodifyNews($bdd, $erreurr);
                        break;
                    case 'pageajouternews':
                        PageajouterNews($bdd);
                        break;
                    default:
                        $erreurr[] = 'Erreur : Erreur d\'appel php';
                        throw new Exception('Erreur : Erreur d\'appel php');
                        require('view/erreur.php');
                        break;
                }
            }
        } catch (Exception $e) {
            $erreurr[] = $e->getMessage();
            require('view/erreur.php');
        } catch (PDOException $e2) {
            $erreurr[] = "Erreur inattendue";
            require('view/erreur.php');
        }
    }
}

function PageAdmin($bdd)
{
    if (isset($_SESSION['pseudo'])) {
        $pseudo = $_SESSION['pseudo'];
    } else {
        $pseudo = null;
    }
    if (isset($_POST['recherche'])) {
        $recherche = $_POST['recherche'];
    } else {
        $recherche = null;
    }
    if (isset($_SESSION['statu'])) {
        $statu = $_SESSION['statu'];
    } else {
        $statu = null;
    }
    $pseudo = filter_var($pseudo,FILTER_SANITIZE_STRING);
    $recherche = filter_var($recherche,FILTER_SANITIZE_STRING);
    $statu = filter_var($statu,FILTER_SANITIZE_STRING);
    $modeladmin = new ModeleAdmin();
    $modeladmin->PageAdmin($pseudo, $recherche, $statu,$bdd);
}

function delArticle($bdd, $erreurr)
{
    $articleID = $_GET['id_billet'];
    $articleID = filter_var($articleID,FILTER_SANITIZE_NUMBER_INT);
    Validator::vaidation_articleID($articleID, $erreurr);
    $modeladmin = new ModeleAdmin();
    $modeladmin->delArticle($articleID, $bdd);
}

function delCommentaireAdmin($bdd, $erreurr)
{
    $commentaireID = $_GET['id_commentaire'];
    $commentaireID = filter_var($commentaireID,FILTER_SANITIZE_NUMBER_INT);
    Validator::validation_commentaireID($commentaireID, $erreurr);
    $modeladmin = new ModeleAdmin();
    $modeladmin->delCommentaire($commentaireID, $bdd);
}

function delMembre($bdd, $erreurr)
{
    $membreID = $_GET['id_membre'];
    $membreID = filter_var($membreID,FILTER_SANITIZE_NUMBER_INT);
    $getpseudo = $_GET['pseudo'];
    $getpseudo = filter_var($getpseudo,FILTER_SANITIZE_STRING);
    Validator::validation_membreIDandgetpseudo($membreID, $getpseudo, $erreurr);
    $modeladmin = new ModeleAdmin();
    $modeladmin->delMembre($membreID, $getpseudo, $bdd);
}

function addNews($bdd, $erreurr)
{
    $postcontenu = $_POST['contenu'];
    $posttitre = $_POST['titre'];
    $posttitre = filter_var($posttitre,FILTER_SANITIZE_STRING);
    Validator::validation_postcontenuandposttitre($postcontenu, $posttitre, $erreurr);
    $modeladmin = new ModeleAdmin();
    $modeladmin->addNews($postcontenu, $posttitre, $bdd);
}

function PageajouterNews($bdd)
{
    if (isset($_SESSION['pseudo'])) {
        $pseudo = $_SESSION['pseudo'];
    } else {
        $pseudo = null;
    }
    if (isset($_SESSION['statu'])) {
        $statu = $_SESSION['statu'];
    } else {
        $statu = null;
    }
    $pseudo = filter_var($pseudo,FILTER_SANITIZE_STRING);
    $statu = filter_var($statu,FILTER_SANITIZE_STRING);
    $modeladmin = new ModeleAdmin();
    $modeladmin->PageajouterNews($pseudo, $statu,$bdd);
}

function modifyNews($bdd, $erreurr)
{
    $postcontenu = $_POST['contenu'];
    $posttitre = $_POST['titre'];
    $articleID = $_GET['id_billet'];
    $posttitre = filter_var($posttitre,FILTER_SANITIZE_STRING);
    $articleID = filter_var($articleID,FILTER_SANITIZE_NUMBER_INT);
    Validator::validation_postcontenuandposttitre($posttitre, $posttitre, $erreurr);
    Validator::vaidation_articleID($articleID, $erreurr);
    $modeladmin = new ModeleAdmin();
    $modeladmin->modifyNews($postcontenu, $posttitre, $articleID, $bdd);
}

function PagemodifyNews($bdd,$erreurr)
{
    if (isset($_SESSION['pseudo'])) {
        $pseudo = $_SESSION['pseudo'];
    } else {
        $pseudo = null;
    }
    if (isset($_SESSION['statu'])) {
        $statu = $_SESSION['statu'];
    } else {
        $statu = null;
    }
    $articleID = $_GET['id_billet'];
    $articleID = filter_var($articleID,FILTER_SANITIZE_NUMBER_INT);
    Validator::vaidation_articleID($articleID, $erreurr);
    $modeladmin = new ModeleAdmin();
    $modeladmin->PagemodifyNews($pseudo, $articleID, $statu,$bdd);
}
