<?php
require('controller/admin.php');
require('controller/user.php');
require('controller/news.php');
class FrontController
{
    function __construct()
    {
        $bdd = DBApp::getDatabase();
        $erreurr = array();

        $listeActionNews = array('listeArticle', 'Article', 'addCommententaire', 'delCommentaireNews');
        $listeActionUser = array('connexion', 'pageconnexion', 'pageinscription', 'delcommentaireMembre', 'pageprofil', 'inscription', 'deconnexion', 'modifierprofil');
        $listeActionAdmin = array('admin', 'delArticle', 'delCommentaireAdmin', 'delMembre', 'ajouterNews', 'modifierNews', 'pagemodifiernews', 'pageajouternews');

        session_start();

        try {
            if (isset($_GET['action'])) {
                $action = $_REQUEST['action'];
                if (in_array($action, $listeActionNews)) {
                    $news = new News($bdd, $erreurr);
                }
                if (in_array($action, $listeActionUser)) {
                    $user = new User($bdd,$erreurr);
                }
                if (in_array($action, $listeActionAdmin)) {
                    $admin = new Admin($bdd, $erreurr);
                }
            } else {
                $news = new News($bdd, $erreurr);
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
