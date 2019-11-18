<?php
try{
    $bdd = new PDO('mysql:host=localhost;dbname=blog_project;charset=utf8','root','');
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
}catch(Exception $e){
    die('Erreur :'.$e->getMessage());
}

$req = $bdd->prepare('delete from commentaires where id=?');
$req->execute(array($_GET['id']));
header('location: admin.php');