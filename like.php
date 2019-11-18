<?php
try{
    $bdd = new PDO('mysql:host=localhost;dbname=blog_project;charset=utf8','root','');
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
}catch(Exception $e){
    die('Erreur :'.$e->getMessage());
}
session_start();

if(isset($_GET['id']) AND $_GET['id'] != NULL) {
    $req = $bdd->prepare('SELECT id FROM commentaires WHERE id = ?');
    $req->execute(array($_GET['id']));
    if($req->rowCount() == 1) {
        $check_like = $bdd->prepare('SELECT id FROM like WHERE id_commentaires = ? AND id_membres = ?');
        $check_like->execute(array($_GET['id'],$_SESSION['id']));
        if($check_like->rowCount() == 1) {
            $del = $bdd->prepare('DELETE FROM like WHERE id_commentaires = ? AND id_membres = ?');
            $del->execute(array($_GET['id'], $_SESSION['id']));
        } else {
            $ins = $bdd->prepare('INSERT INTO like (id_commentaires, id_membres) VALUES (?, ?)');
            $ins->execute(array($_GET['id'], $_SESSION['id']));
        } 
       header('Location: commentaires.php?id_billet='.$_GET['id_billet']);
    }else{
        header('Location: commentaires.php?id_billet='.$_GET['id_billet']);
    }
}else{
    header('Location: commentaires.php?id_billet='.$_GET['id_billet']);
}
