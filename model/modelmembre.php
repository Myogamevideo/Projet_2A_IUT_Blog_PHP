<?php
function getBanni($bdd, $pseudo, $statu)
{
    if (isset($statu) and $statu == 'banni') {
        header('location: affichagebanni.php');
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
                    header('location: membre.php?action=connexion');
                } else {
                    throw new Exception('<strong>Information : </strong> Adresse email non valide');
                }
            }
        }
    } else {
        throw new Exception('<strong>Information : </strong> Un ou plusieurs champs sont vide');
    }
}

function getDeconnexion($bdd)
{
    $_SESSION = array();
    session_destroy();
    setcookie('pseudo', '');
    setcookie('mdp', '');
    header('location: index.php');
}

function getProfil($bdd, $pseudo)
{
    $req = $bdd->prepare('select * from membres where pseudo=?');
    $req->execute(array($pseudo));
    $profil = $req->fetch();
    return $profil;
}

function modifyProfil($bdd, $postpseudo, $postemail, $profil)
{
    if (isset($postpseudo) && isset($postemail) && $postpseudo != NULL && $postemail != NULL) {
        $req = $bdd->prepare('select count(*) as nbr from membres where pseudo=?');
        $req->execute(array($postpseudo));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        if ($data['nbr'] != 0) {
            throw new Exception('<strong>Information : </strong> pseudo dejà utilisé');
        } else {
            $req = $bdd->prepare('update membres set pseudo=:pseudo, email=:email where pseudo="' . $profil['pseudo'] . '"');
            $req->execute(array(
                'pseudo' => $postpseudo,
                'email' => $postemail,
            ));
            $req = $bdd->prepare('update commentaires set auteur=:pseudo where auteur="' . $profil['pseudo'] . '"');
            $req->execute(array('pseudo' => $postpseudo));
            $_SESSION['pseudo'] = $postpseudo;
            header('location: membre.php?action=profil');
        }
    } else {
        throw new Exception('<strong>Information : </strong> Un ou plusieurs champs sont vide');
    }
}

function getCommentaire($bdd, $pseudo)
{
    $comments = $bdd->prepare('select C.id , B.titre , C.auteur , C.commentaire , C.date_commentaire from billets B , commentaires C where C.id_billet=B.id and C.auteur=?');
    $comments->execute(array($pseudo));
    return $comments;
}

function suppCommentaire($bdd, $commentaireID)
{
    $ligneaffecter = $bdd->prepare('delete from commentaires where id=?');
    $ligneaffecter->execute(array($commentaireID));
    return $ligneaffecter;
}