<?php
require_once('model/modelmembre.php');

function Connexion($bdd, $id, $pseudo, $statu, $postpseudo, $postpassword, $postcase, $cookiepseudo, $cookiepassword, $cookiestatu, $managernews, $managercomments)
{
    getBanni($bdd, $pseudo, $statu);
    $titre = 'Connexion';
    ob_start();
    require('view/affichageconnexion.php');
    $content = ob_get_clean();
    $connexion = getConnexion($bdd, $postpseudo, $postpassword, $postcase, $cookiepseudo, $cookiepassword, $cookiestatu,$pseudo,$id,$statu);
    $nbcommentaire = $managercomments->getNBCommentaire((string) $pseudo);
    $nbarticle = $managernews->getNBArticle();
    require('view/template.php');
}

function PageConnexion($bdd, $pseudo, $id, $statu, $managernews, $managercomments)
{
    $data = getBanni($bdd, $pseudo, $statu);
    $titre = 'Connexion';
    ob_start();
    require('view/affichageconnexion.php');
    $content = ob_get_clean();
    $nbcommentaire = $managercomments->getNBCommentaire((string) $pseudo);
    $nbarticle = $managernews->getNBArticle();
    require('view/template.php');
}

function Inscription($bdd, $pseudo, $id, $statu, $postpseudo, $postpassword, $postconfig_password, $postemail, $managernews, $managercomments)
{
    $data = getBanni($bdd, $pseudo, $statu);
    $titre = 'Inscription';
    ob_start();
    require('view/affichageinscription.php');
    $content = ob_get_clean();
    $inscription = getInscription($bdd, $postpseudo, $postpassword, $postconfig_password, $postemail);
    $nbcommentaire = $managercomments->getNBCommentaire((string) $pseudo);
    $nbarticle = $managernews->getNBArticle();
    require('view/template.php');
}


function PageInscription($bdd, $pseudo, $id, $statu, $managernews, $managercomments)
{
    $data = getBanni($bdd, $pseudo, $statu);
    $titre = 'Inscription';
    ob_start();
    require('view/affichageinscription.php');
    $content = ob_get_clean();
    $nbcommentaire = $managercomments->getNBCommentaire((string) $pseudo);
    $nbarticle = $managernews->getNBArticle();
    require('view/template.php');
}

function Deconnexion($bdd)
{
    getDeconnexion($bdd);
}

function ModifierProfil($bdd, $pseudo, $statu, $postpseudo, $postemail, $managernews, $managercomments,$managersmembre)
{
    $data = getBanni($bdd, $pseudo, $statu);
    $titre = 'Profil';
    $comments = $managercomments->getListCommentaireByPseudo($pseudo);
    $profil = $managersmembre->getUniqueByPseudo($pseudo);
    ob_start();
    require('view/affichageprofil.php');
    $content = ob_get_clean();
    $mem = new Membre(['id' => $profil->getid(),'pseudo' => $postpseudo,'pass' => $profil->getpass(),'email' => $postemail]);
    $modifierprofil = $managersmembre->update($mem);
    $modifiercommentaire = $managercomments->updateWithProfil($profil->getid() , $postpseudo);
    $nbcommentaire = $managercomments->getNBCommentaire((string) $pseudo);
    $nbarticle = $managernews->getNBArticle();
    require('view/template.php');
}

function PageProfil($bdd, $pseudo, $statu, $managernews, $managercomments,$managersmembre)
{
    $data = getBanni($bdd, $pseudo, $statu);
    $titre = 'Profil';
    $comments = $managercomments->getListCommentaireByPseudo($pseudo);
    $profil = $managersmembre->getUniqueByPseudo($pseudo);
    ob_start();
    require('view/affichageprofil.php');
    $content = ob_get_clean();
    $nbcommentaire = $managercomments->getNBCommentaire((string) $pseudo);
    $nbarticle = $managernews->getNBArticle();
    require('view/template.php');
}

function delCommentaire($commentaireID, $managercomments)
{
    $ligneaffecter = $managercomments->delete($commentaireID);
    if ($ligneaffecter == false) {
        throw new Exception('Impossible de supprimer le commentaire !');
    } else {
        header('Location: membre.php?action=profil');
    }
}
