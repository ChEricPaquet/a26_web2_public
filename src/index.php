<?php
session_start();

require_once 'utils/validationUtils.php';
require_once 'controleur/controleur.php';
require_once 'controleur/controleurArticles.php';
require_once 'controleur/controleurAuth.php';
require_once 'controleur/controleurProfil.php';

try {
    if (!isset($_GET['action'])) {
        afficherPageAccueil();
        return;
    }

    switch ($_GET['action']) {
        case 'afficherPageAccueil':
            afficherPageAccueil();
            break;
        case 'afficherPageConnexion':
            afficherPageConnexion();
            break;
        case 'afficherPageInscription':
            afficherPageInscription();
            break;
        case 'afficherPageProfil':
            afficherPageProfil();
            break;
        case 'afficherPageArticles':
            afficherPageArticles();
            break;
        case 'afficherPageNouvelArticle':
            afficherPageNouvelArticle();
            break;
        case 'connecter':
            connecter();
            break;
        case 'inscrire':
            inscrire();
            break;
        case 'deconnecter':
            deconnecter();
            break;
        case 'modifierProfil':
            modifierProfil();
            break;
        case 'ajouterArticle':
            ajouterArticle();
            break;
        default:
            throw new Exception('404 : Action non supportée');
    }
} catch (PDOException $e) {
    $msgErreur = $e->getMessage();
    require 'vue/erreur.php';
} catch (Exception $ex) {
    $msgErreur = $ex->getMessage();
    require 'vue/erreur.php';
}
