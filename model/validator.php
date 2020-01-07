<?php

class Validator{
    static function vaidation_articleID($articleID,$erreurr){
        if (!isset($articleID) || $articleID < 0) {
            $erreurr[] = 'Erreur : aucun identifiant de billet envoyé';
            throw new Exception('Erreur : aucun identifiant de billet envoyé');
        }
    }

    static function validation_articleIDandpseudoandpostcommentaire($articleID,$pseudo,$postcommentaire,$erreurr){
        if (isset($articleID) && $articleID > 0) {
            if (empty($pseudo) || empty($postcommentaire)) {
                $erreurr[] = 'Erreur : tous les champs ne sont pas remplis !';
                throw new Exception('Erreur : tous les champs ne sont pas remplis !');
            }
        } else {
            $erreurr[] = 'Erreur : aucun identifiant de billet envoyé';
            throw new Exception('Erreur : aucun identifiant de billet envoyé');
        }
    }

    static function validation_articleIDandcommentaireID($articleID,$commentaireID,$erreurr){
        if (isset($articleID) && $articleID > 0) {
            if (!isset($commentaireID) || $commentaireID < 0) {
                $erreurr[] = 'Erreur : aucun identifiant de commentaire envoyé';
                throw new Exception('Erreur : aucun identifiant de commentaire envoyé');
            }
        } else {
            $erreurr[] = 'Erreur : aucun identifiant de billet envoyé';
            throw new Exception('Erreur : aucun identifiant de billet envoyé');
        }
    }

    static function validation_commentaireID($commentaireID,$erreurr){
        if (!isset($commentaireID) || $commentaireID < 0) {
            $erreurr[] = 'Erreur : aucun identifiant de commentaire envoyé';
            throw new Exception('Erreur : aucun identifiant de commentaire envoyé');
        }
    }

    static function validation_membreIDandgetpseudo($membreID, $getpseudo,$erreurr){
        if (isset($membreID) && $membreID > 0) {
            if(!isset($getpseudo) || empty($getpseudo)){
                $erreurr[] = 'Erreur : aucun pseudo de membre envoyé';
                throw new Exception('Erreur : aucun pseudo de membre envoyé');      
            }
        }else{
            $erreurr[] = 'Erreur : aucun identifiant de membre envoyé';
            throw new Exception('Erreur : aucun identifiant de membre envoyé');
        }
    }

    static function validation_postcontenuandposttitre($postcontenu,$posttitre,$erreurr){
        if(!isset($postcontenu) || empty($postcontenu)){
            $erreurr[] = 'Erreur : aucun contenu envoyé';
            throw new Exception('Erreur : aucun contenu envoyé');      
        }
        if(!isset($posttitre) || empty($posttitre)){
            $erreurr[] = 'Erreur : aucun titre envoyé';
            throw new Exception('Erreur : aucun titre envoyé');      
        }
    }

    static function validation_postpassword($postpassword,$erreurr){
        if(!isset($postpassword) || empty($postpassword)){
            $erreurr[] = 'Erreur : tous les champs ne sont pas remplis !';
            throw new Exception('Erreur : tous les champs ne sont pas remplis !');      
        }
    }

    static function validation_postconfig_password($postconfig_password,$erreurr){
        if(!isset($postconfig_password) || empty($postconfig_password)){
            $erreurr[] = 'Erreur : tous les champs ne sont pas remplis !';
            throw new Exception('Erreur : tous les champs ne sont pas remplis !');      
        }
    }

    static function validation_postpseudo($postpseudo,$erreurr){
        if(!isset($postpseudo) || empty($postpseudo)){
            $erreurr[] = 'Erreur : tous les champs ne sont pas remplis !';
            throw new Exception('Erreur : tous les champs ne sont pas remplis !');      
        }
    }

    static function validation_postemail($postemail,$erreurr){
        if(!isset($postemail) || empty($postemail)){
            $erreurr[] = 'Erreur : tous les champs ne sont pas remplis !';
            throw new Exception('Erreur : tous les champs ne sont pas remplis !');      
        }
    }
}
