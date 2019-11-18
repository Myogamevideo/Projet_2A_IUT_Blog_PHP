<?php
try{
    $bdd = new PDO('mysql:host=localhost;dbname=blog_project;charset=utf8','root','');
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
}catch(Exception $e){
    die('Erreur :'.$e->getMessage());
}

$req = $bdd->prepare('update membres set status=\'banni\' where id=?');
$req->execute(array($_GET['id']));

$req = $bdd->prepare('delete from commentaires where auteur=?');
$req->execute(array($_GET['pseudo']));

header('location: admin.php');