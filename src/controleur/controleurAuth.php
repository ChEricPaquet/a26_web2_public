<?php
require_once "modele/modeleUtilisateurs.php";

function afficherPageConnexion()
{
    // Vérifier si l'utilisateur est connecté
    if (isset($_SESSION['utilisateur'])) {
        // Rediriger vers la page de profil si l'utilisateur est déjà connecté
        header('Location: index.php?action=afficherPageProfil');
        exit;
    }
    require 'vue/connexion.php';
}

function afficherPageInscription()
{
    // Vérifier si l'utilisateur est connecté
    if (isset($_SESSION['utilisateur'])) {
        // Rediriger vers la page de profil si l'utilisateur est déjà connecté
        header('Location: index.php?action=afficherPageProfil');
        exit;
    }

    require 'vue/inscription.php';
}

function validerDonneesAuthentification()
{
    $erreurs = [];
    if (empty($_POST['nomUtilisateur']) || mb_strlen($_POST['nomUtilisateur']) < 3 || mb_strlen($_POST['nomUtilisateur']) > 45) {
        $erreurs[] = 'Le nom d\'utilisateur est requis et doit contenir entre 3 et 45 caractères.';
    }
    if (empty($_POST['motDePasse']) || mb_strlen($_POST['motDePasse']) < 6 || mb_strlen($_POST['motDePasse']) > 45) {
        $erreurs[] = 'Le mot de passe est requis et doit contenir entre 6 et 45 caractères.';
    }
    return $erreurs;
}

function connecter()
{
    $erreurs = validerDonneesAuthentification();
    if (!empty($erreurs)) {
        // Ajout des erreurs à la session pour les afficher sur la page de connexion
        $_SESSION['erreurs'] = $erreurs;
        header('Location: index.php?action=afficherPageConnexion');
        exit;
    }

    // Vérification des informations d'identification
    $requeteUtilisateurs = ModeleUtilisateurs::obtenirUtilisateur($_POST['nomUtilisateur']);
    $utilisateur = $requeteUtilisateurs->fetch();
    if (!$utilisateur || !password_verify($_POST['motDePasse'], $utilisateur['mot_de_passe'])) {
        $_SESSION['erreurs'] = ['Nom d\'utilisateur ou mot de passe incorrect.'];
        header('Location: index.php?action=afficherPageConnexion');
        exit;
    }

    // Stocker les informations de l'utilisateur dans la session
    $_SESSION['utilisateur'] = $utilisateur;

    // Rediriger vers la page du profil après une connexion réussie
    header('Location: index.php?action=afficherPageProfil');
}

function inscrire()
{
    $erreurs = validerDonneesAuthentification();
    if (!empty($erreurs)) {
        // Ajout des erreurs à la session pour les afficher sur la page d'inscription
        $_SESSION['erreurs'] = $erreurs;
        header('Location: index.php?action=afficherPageInscription');
        exit;
    }

    try {
        // Hachage du mot de passe
        $motDePasseHache = password_hash($_POST['motDePasse'], PASSWORD_DEFAULT);
        // Ajout de l'utilisateur dans la base de données
        ModeleUtilisateurs::ajouterUtilisateur($_POST['nomUtilisateur'], $motDePasseHache);
        // Après une inscription réussie, connecter automatiquement l'utilisateur
        connecter();
    } catch (PDOException $e) {
        // Gérer l'erreur, par exemple si le nom d'utilisateur est déjà pris
        $_SESSION['erreurs'] = ['Le nom d\'utilisateur est déjà pris. Veuillez en choisir un autre.'];
        header('Location: index.php?action=afficherPageInscription');
        exit;
    }
}

function deconnecter()
{
    // Vider les données de la session
    session_unset();
    // Détruire la session pour déconnecter l'utilisateur
    session_destroy();
    // Rediriger vers la page d'accueil après la déconnexion
    header('Location: index.php?action=afficherPageAccueil');
    exit;
}
