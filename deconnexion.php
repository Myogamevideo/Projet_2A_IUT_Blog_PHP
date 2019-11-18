<?php
    session_start();
    $_SESSION = array();
    session_destroy();
    setcookie('pseudo','');
    setcookie('mdp','');
    header('location: index.php');
    