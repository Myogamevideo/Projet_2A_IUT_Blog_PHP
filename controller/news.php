<?php
require_once('model/modelindex.php');

class News
{
    function __construct($bdd, $erreurr)
    {
        try {
            if (isset($_GET['action'])) {
                $action = $_REQUEST['action'];
                switch ($action) {
                    case 'listeArticle':
                        listeArticle($bdd);
                        break;
                    case 'Article':
                        Article($bdd, $erreurr);
                        break;
                    case 'addCommententaire':
                        addCommententaire($bdd, $erreurr);
                        break;
                    case 'delCommentaireNews':
                        delCommentaireNews($bdd, $erreurr);
                        break;
                    default:
                        $erreurr[] = 'Erreur : Erreur d\'appel php';
                        throw new Exception('Erreur : Erreur d\'appel php');
                        require('view/erreur.php');
                        break;
                }
            } else {
                listeArticle($bdd);
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

function listeArticle($bdd)
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
    $modelindex = new ModeleIndex();
    $modelindex->listeArticle($bdd, $pseudo, $statu);
}

function Article($bdd, $erreurr)
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
    $pseudo = filter_var($pseudo,FILTER_SANITIZE_STRING);
    $statu = filter_var($statu,FILTER_SANITIZE_STRING);
    $articleID = filter_var($articleID,FILTER_SANITIZE_NUMBER_INT);
    Validator::vaidation_articleID($articleID, $erreurr);
    $modelindex = new ModeleIndex();
    $modelindex->Article($articleID, $pseudo, $statu, $bdd);
}

function addCommententaire($bdd, $erreurr)
{
    if (isset($_SESSION['pseudo'])) {
        $pseudo = $_SESSION['pseudo'];
    } else {
        $pseudo = null;
    }
    $articleID = $_GET['id_billet'];
    $postcommentaire = $_POST['commentaire'];
    $pseudo = filter_var($pseudo,FILTER_SANITIZE_STRING);
    $articleID = filter_var($articleID,FILTER_SANITIZE_NUMBER_INT);
    Validator::validation_articleIDandpseudoandpostcommentaire($articleID, $pseudo, $postcommentaire, $erreurr);
    $modelindex = new ModeleIndex();
    $modelindex->addCommententaire($articleID, $pseudo, $postcommentaire, $bdd);
}

function delCommentaireNews($bdd, $erreurr)
{
    $articleID = $_GET['id_billet'];
    $commentaireID = $_GET['id_commentaire'];
    $articleID = filter_var($articleID,FILTER_SANITIZE_NUMBER_INT);
    $commentaireID = filter_var($commentaireID,FILTER_SANITIZE_NUMBER_INT);
    Validator::validation_articleIDandcommentaireID($articleID, $commentaireID, $erreurr);
    $modelindex = new ModeleIndex();
    $modelindex->delCommentaire($commentaireID, $articleID, $bdd);
}
