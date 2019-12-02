<?php
function getBDD()
{
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=blog_project;charset=utf8', 'root', '');
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        die('Erreur :' . $e->getMessage());
    }
    session_start();
    return $bdd;
}
