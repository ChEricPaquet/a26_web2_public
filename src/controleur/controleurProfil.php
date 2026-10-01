<?php
require_once "modele/modeleUtilisateurs.php";

function afficherPageProfil()
{
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['utilisateur'])) {
        // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
        header('Location: index.php?action=afficherPageConnexion');
        exit;
    }
    require 'vue/profil.php';
}

function validerDonneesProfil()
{
    $erreurs = [];
    if (empty($_POST['nomUtilisateur']) || mb_strlen($_POST['nomUtilisateur']) < 3 || mb_strlen($_POST['nomUtilisateur']) > 45) {
        $erreurs[] = 'Le nom d\'utilisateur est requis et doit contenir entre 3 et 45 caractères.';
    }
    if (
        // Valider seulement si le champ n'est pas vide. Le champ est optionnel.
        !empty($_POST['email']) && (
            !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
            || mb_strlen($_POST['email']) > 255
        )
    ) {
        $erreurs[] = 'Veuillez entrer une adresse email valide.';
    }
    if (
        // Valider seulement si le champ n'est pas vide. Le champ est optionnel.
        !empty($_POST['image']) && (
            !validerUrl($_POST['image'])
            || mb_strlen($_POST['image']) > 2048
        )
    ) {
        $erreurs[] = 'Veuillez entrer une URL d\'image valide.';
    }
    return $erreurs;
}

function modifierProfil()
{
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['utilisateur'])) {
        header('Location: index.php?action=afficherPageConnexion');
        exit;
    }

    $erreurs = validerDonneesProfil();
    if (!empty($erreurs)) {
        $_SESSION['erreurs'] = $erreurs;
        header('Location: index.php?action=afficherPageProfil');
        exit;
    }

    try {
        // Mettre à jour les informations de l'utilisateur dans la base de données
        ModeleUtilisateurs::mettreAJourUtilisateur(
            $_SESSION['utilisateur']['nom'],
            $_POST['nomUtilisateur'],
            empty($_POST['email']) ? null : $_POST['email'], // Utiliser null si le champ est vide
            empty($_POST['image']) ? null : $_POST['image']  // Utiliser null si le champ est vide
        );

        $_SESSION['utilisateur']['nom'] = $_POST['nomUtilisateur'];
        $_SESSION['utilisateur']['email'] = $_POST['email'] ?? ''; // Si email n'est pas fourni, le définir à une chaîne vide
        $_SESSION['utilisateur']['image'] = $_POST['image'] ?? ''; // Si image n'est pas fourni, le définir à une chaîne vide

        // Rediriger vers la page du profil après la modification
        header('Location: index.php?action=afficherPageProfil');
    } catch (PDOException $e) {
        // Gérer les erreurs ici
        // Par exemple, si le nouveau nom d'utilisateur est déjà pris
        // ou toute autre erreur de base de données
        $_SESSION['erreurs'] = ['Une erreur est survenue lors de la mise à jour du profil.'];
        header('Location: index.php?action=afficherPageProfil');
    }
}
