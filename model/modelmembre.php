<?php
class ModeleMembre{
    public function Connexion($bdd,$id, $pseudo, $statu, $postpseudo, $postpassword, $postcase, $cookiepseudo, $cookiepassword, $cookiestatu)
    {
        $managercomments = new CommentaireManagerPDO($bdd);
        $managernews = new ArticleManagerPDO($bdd);
        $titre = 'Connexion';
        ob_start();
        require('view/affichageconnexion.php');
        $content = ob_get_clean();
        $connexion = getConnexion($bdd,$postpseudo, $postpassword, $postcase, $cookiepseudo, $cookiepassword, $cookiestatu,$pseudo,$id,$statu);
        $nbcommentaire = $managercomments->getNBCommentaire((string) $pseudo);
        $nbarticle = $managernews->getNBArticle();
        require('view/template.php');
    }
    
    public function PageConnexion($pseudo,$statu,$bdd)
    {
        $managercomments = new CommentaireManagerPDO($bdd);
        $managernews = new ArticleManagerPDO($bdd);
        $titre = 'Connexion';
        ob_start();
        require('view/affichageconnexion.php');
        $content = ob_get_clean();
        $nbcommentaire = $managercomments->getNBCommentaire((string) $pseudo);
        $nbarticle = $managernews->getNBArticle();
        require('view/template.php');
    }
    
    public function Inscription($bdd,$pseudo,$postpseudo, $postpassword, $postconfig_password, $postemail)
    {
        $managercomments = new CommentaireManagerPDO($bdd);
        $managernews = new ArticleManagerPDO($bdd);
        $titre = 'Inscription';
        ob_start();
        require('view/affichageinscription.php');
        $content = ob_get_clean();
        $inscription = getInscription($bdd,$postpseudo, $postpassword, $postconfig_password, $postemail);
        $nbcommentaire = $managercomments->getNBCommentaire((string) $pseudo);
        $nbarticle = $managernews->getNBArticle();
        require('view/template.php');
    }
    
    
    public function PageInscription($pseudo,$statu,$bdd)
    {
        $managercomments = new CommentaireManagerPDO($bdd);
        $managernews = new ArticleManagerPDO($bdd);
        $titre = 'Inscription';
        ob_start();
        require('view/affichageinscription.php');
        $content = ob_get_clean();
        $nbcommentaire = $managercomments->getNBCommentaire((string) $pseudo);
        $nbarticle = $managernews->getNBArticle();
        require('view/template.php');
    }
    
    public function Deconnexion()
    {
        getDeconnexion();
    }
    
    public function ModifierProfil($pseudo,$postpseudo,$postemail, $bdd)
    {
        $managercomments = new CommentaireManagerPDO($bdd);
        $managermembre = new MembreManagerPDO($bdd);
        $managernews = new ArticleManagerPDO($bdd);
        $titre = 'Profil';
        $comments = $managercomments->getListCommentaireByPseudo($pseudo);
        $profil = $managermembre->getUniqueByPseudo($pseudo);
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
    
    public function PageProfil($pseudo,$statu,$bdd)
    {
        $managercomments = new CommentaireManagerPDO($bdd);
        $managermembre = new MembreManagerPDO($bdd);
        $managernews = new ArticleManagerPDO($bdd);
        $titre = 'Profil';
        $comments = $managercomments->getListCommentaireByPseudo($pseudo);
        $profil = $managermembre->getUniqueByPseudo($pseudo);
        ob_start();
        require('view/affichageprofil.php');
        $content = ob_get_clean();
        $nbcommentaire = $managercomments->getNBCommentaire((string) $pseudo);
        $nbarticle = $managernews->getNBArticle();
        require('view/template.php');
    }
    
    public function delCommentaire($commentaireID, $bdd)
    {
        $managercomments = new CommentaireManagerPDO($bdd);
        $ligneaffecter = $managercomments->delete($commentaireID);
        if ($ligneaffecter == false) {
            throw new Exception('Impossible de supprimer le commentaire !');
        } else {
            header('Location: index.php?action=profil');
        }
    }
}


function getConnexion($db, $postpseudo, $postpassword, $postcase, $cookiepseudo, $cookiepassword, $cookiestatu,$pseudo,$id,$statu)
{
    if (isset($cookiepseudo) && isset($cookiepassword) && isset($cookiestatu)) {
        $query = 'SELECT pass FROM membres WHERE pseudo=:pseudo';
        $req = $db->query($query, array(':pseudo' => $cookiepseudo));

        $donne = $req->fetch();
        if ($cookiepassword == $donne['pass']) {
            $_SESSION['id'] = $donne['id'];
            $_SESSION['pseudo'] = $cookiepseudo;
            $_SESSION['statu'] = $donne['statu'];
            $id = $donne['id'];
            $pseudo = $cookiepseudo;
            $statu = $donne['statu'];
            header('location: index.php');
        }
    }

    if (isset($postpseudo) && isset($postpassword) && $postpseudo != NULL and $postpassword != NULL) {
        $query = 'SELECT count(*) AS nbr FROM membres WHERE pseudo=:pseudo';
        $req = $db->query($query, array(':pseudo' => $postpseudo));
        $donne = $req->fetch(PDO::FETCH_ASSOC);
        if ($donne['nbr'] != 0) {
            $query = 'SELECT pass FROM membres WHERE pseudo=:pseudo';
            $req = $db->query($query, array(':pseudo' => $postpseudo));
            $donne = $req->fetch(PDO::FETCH_ASSOC);
            $verify = password_verify($postpassword, $donne['pass']);
            if ($verify == true) {
                $query = 'SELECT id,statu FROM membres WHERE pseudo=:pseudo';
                $req = $db->query($query, array(':pseudo' => $postpseudo));
                $donne = $req->fetch(PDO::FETCH_ASSOC);
                $_SESSION['id'] = $donne['id'];
                $_SESSION['pseudo'] = $postpseudo;
                $_SESSION['statu'] = $donne['statu'];
                $id = $donne['id'];
                $pseudo = $postpseudo;
                $statu = $donne['statu'];
                echo 'Connectée';
                if ($postcase == 'on') {
                    setcookie('pseudo', $postpseudo, time() + 3600, null, null, false, true);
                    $cookiepseudo = $postpseudo;
                    $query = 'SELECT pass,statu FROM membres WHERE pseudo=:pseudo';
                    $req = $db->query($query, array(':pseudo' => $postpseudo));
                    $donne = $req->fetch();
                    setcookie('password', $donne['pass'], time() + 3600, null, null, false, true);
                    $cookiepassword = $donne['pass'];
                    setcookie('statu', $donne['statu'], time() + 3600, null, null, false, true);
                    $cookiestatu = $donne['statu'];
                    header('location: index.php');
                } else {
                    header('location: index.php');
                }
            } else {
                throw new Exception('<strong>Information : </strong> Mauvais identifiant ou mot de passe');
            }
        } else {
            throw new Exception('<strong>Information : </strong> Mauvais identifiant ou mot de passe');
        }
    } else {
        throw new Exception('<strong>Information : </strong> Un ou plusieurs champs sont vide');
    }

    
}

function getInscription($db, $postpseudo, $postpassword, $postconfig_password, $postemail)
{
    if (isset($postpseudo) && isset($postpassword) && isset($postconfig_password) && isset($postemail) && $postpseudo != NULL && $postpassword != NULL && $postconfig_password != NULL && $postemail != NULL) {
        $query = 'SELECT count(*) AS nbr FROM membres WHERE pseudo=:pseudo';
        $req = $db->query($query, array(':pseudo' => $postpseudo));
        $donne = $req->fetch(PDO::FETCH_ASSOC);
        if ($donne['nbr'] != 0) {
            throw new Exception('<strong>Information : </strong> Pseudo dejà utilisé');
        } else {
            if ($postconfig_password != $postpassword) {
                throw new Exception('<strong>Information : </strong> Mot de passe différent par rapport à la confimration');
            } else {
                if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $postemail)) {
                    $pass_hach = password_hash($postpassword, PASSWORD_DEFAULT);
                    $query = 'INSERT INTO membres (pseudo,pass,email,date_inscription,statu) VALUES (:pseudo,:pass,:email,now(),:statu)';
                    $req = $db->query($query, array(
                        ':pseudo' => $postpseudo,
                        ':pass' => $pass_hach,
                        ':email' => $postemail,
                        ':statu'  => 'null'));
                    header('location: index.php?action=pageconnexion');
                } else {
                    throw new Exception('<strong>Information : </strong> Adresse email non valide');
                }
            }
        }
    } else {
        throw new Exception('<strong>Information : </strong> Un ou plusieurs champs sont vide');
    }
}

function getDeconnexion()
{
    $_SESSION = array();
    session_destroy();
    setcookie('pseudo', '');
    setcookie('mdp', '');
    header('location: index.php');
}

function updateProfil(Membre $profil , $pseudo , $email)
{
  $query = 'SELECT count(*) AS nbr FROM membres WHERE pseudo = :pseudo';
  $requete = $this->db->query($query, array(':pseudo' => (String) $pseudo));
  $data = $requete->fetch(PDO::FETCH_ASSOC);
  if ($data['nbr'] != 0) {
      throw new Exception('<strong>Information : </strong> pseudo dejà utilisé');
  } else {
    $query = 'UPDATE membres SET pseudo = :pseudo, email = :email WHERE pseudo = "' . $profil->getpseudo() . '"';
    $requete = $this->db->query($query, array(':pseudo' => (String) $pseudo , ':email' => (String) $email));
    $query = 'UPDATE commentaires SET auteur = :pseudo WHERE auteur = "' . $profil->getpseudo() . '"';
    $requete = $this->db->query($query, array(':pseudo' => (String) $pseudo));
    $_SESSION['pseudo'] = $pseudo;
    header('location: index.php?action=profil');
  }
}



