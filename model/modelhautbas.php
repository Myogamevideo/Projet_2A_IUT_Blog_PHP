<?php
function getNBCommentaire($bdd, $pseudo)
{
    $reponse = $bdd->prepare('select count(*) as nbcommentaire from commentaires where auteur=?');
    $reponse->execute(array($pseudo));
    $nbcommentaire = $reponse->fetch();
    setcookie('nbcommentaire', $nbcommentaire['nbcommentaire'], time() + 3600, null, null, false, true);
    return $nbcommentaire;
}

function getNBArticle($bdd)
{
    $req = $bdd->query('select count(id) as nb from billets');
    $nbarticle = $req->fetch();
    return $nbarticle;
}
