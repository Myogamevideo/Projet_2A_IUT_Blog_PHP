<?php
require_once('model/modelmembre.php');

class User
{
    function __construct($bdd,$erreurr)
    {   
        try {
            if (isset($_GET['action'])) {
                $action = $_REQUEST['action'];
                switch ($action) {
                    case 'connexion':
                        Connexion($bdd, $erreurr);
                        break;
                    case 'pageconnexion':
                        PageConnexion($bdd, $erreurr);
                        break;
                    case 'pageinscription':
                        PageInscription($bdd, $erreurr);
                        break;
                    case 'delCommentaireMembre':
                        delCommentaireMembre($bdd, $erreurr);
                        break;
                    case 'pageprofil':
                        PageProfil($bdd);
                        break;
                    case 'inscription':
                        Inscription($bdd, $erreurr);
                        break;
                    case 'deconnexion':
                        Deconnexion($bdd);
                        break;
                    case 'modifierprofil':
                        ModifierProfil($bdd, $erreurr);
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

function Connexion($bdd, $erreurr)
{
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
    $postpassword = $_POST['password'];
    $postpseudo = $_POST['pseudo'];
    if (isset($_POST['case'])) {
        $postcase = $_POST['case'];
    } else {
        $postcase = null;
    }
    $cookiestatu = filter_var($cookiestatu,FILTER_SANITIZE_STRING);
    $cookiepseudo = filter_var($cookiepseudo,FILTER_SANITIZE_STRING);
    $pseudo = filter_var($pseudo,FILTER_SANITIZE_STRING);
    $statu = filter_var($statu,FILTER_SANITIZE_STRING);
    $id = filter_var($id,FILTER_SANITIZE_NUMBER_INT);
    Validator::validation_postpassword($postpassword, $erreurr);
    Validator::validation_postpseudo($postpseudo, $erreurr);
    $modelmembre = new ModeleMembre();
    $modelmembre->Connexion($bdd, $id, $pseudo, $statu, $postpseudo, $postpassword, $postcase, $cookiepseudo, $cookiepassword, $cookiestatu);
}

function PageConnexion($bdd, $erreurr)
{
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
    $modelmembre = new ModeleMembre();
    $modelmembre->PageConnexion($pseudo, $statu, $bdd);
}

function Inscription($bdd, $erreurr)
{
    if (isset($_SESSION['pseudo'])) {
        $pseudo = $_SESSION['pseudo'];
    } else {
        $pseudo = null;
    }
    $postpassword = $_POST['password'];
    $postpseudo = $_POST['pseudo'];
    $postconfig_password = $_POST['confi_password'];
    $postemail = $_POST['email'];
    $pseudo = filter_var($pseudo,FILTER_SANITIZE_STRING);
    $postpseudo = filter_var($postpseudo,FILTER_SANITIZE_STRING);
    $postemail = filter_var($postemail,FILTER_SANITIZE_STRING);
    $postemail = filter_var($postemail,FILTER_SANITIZE_STRING);
    Validator::validation_postpassword($postpassword, $erreurr);
    Validator::validation_postpseudo($postpseudo, $erreurr);
    Validator::validation_postconfig_password($postconfig_password, $erreurr);
    Validator::validation_postemail($postemail, $erreurr);
    $modelmembre = new ModeleMembre();
    $modelmembre->Inscription($bdd, $pseudo, $postpseudo, $postpassword, $postconfig_password, $postemail);
}

function PageInscription($bdd, $erreurr)
{
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
    $pseudo = filter_var($pseudo,FILTER_SANITIZE_STRING);
    $statu = filter_var($statu,FILTER_SANITIZE_STRING);
    $modelmembre = new ModeleMembre();
    $modelmembre->PageInscription($pseudo, $statu, $bdd);
}

function Deconnexion()
{
    $modelmembre = new ModeleMembre();
    $modelmembre->Deconnexion();
}

function ModifierProfil($bdd, $erreurr)
{
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
    $postpseudo = $_POST['pseudo'];
    $postemail = $_POST['email'];
    $pseudo = filter_var($pseudo,FILTER_SANITIZE_STRING);
    $statu = filter_var($statu,FILTER_SANITIZE_STRING);
    $postpseudo = filter_var($postpseudo,FILTER_SANITIZE_STRING);
    $postemail = filter_var($postemail,FILTER_SANITIZE_EMAIL);
    Validator::validation_postpseudo($postpseudo, $erreurr);
    Validator::validation_postemail($postemail, $erreurr);
    $modelmembre = new ModeleMembre();
    $modelmembre->ModifierProfil($pseudo, $statu, $postpseudo, $postemail, $bdd);
}

function delCommentaireMembre($bdd, $erreurr)
{
    $commentaireID = $_GET['id_commentaire'];
    $commentaireID = filter_var($commentaireID,FILTER_SANITIZE_NUMBER_INT);
    Validator::validation_commentaireID($commentaireID, $erreurr);
    $modelmembre = new ModeleMembre();
    $modelmembre->delCommentaire($commentaireID, $bdd);
}

function PageProfil($bdd)
{
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
    $pseudo = filter_var($pseudo,FILTER_SANITIZE_STRING);
    $statu = filter_var($statu,FILTER_SANITIZE_STRING);
    $modelmembre = new ModeleMembre();
    $modelmembre->PageProfil($pseudo, $statu, $bdd);
}
