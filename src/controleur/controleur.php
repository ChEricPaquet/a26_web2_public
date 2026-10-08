<?php
require_once "modele/modeleUtilisateurs.php";

function afficherPageAccueil()
{
    require 'vue/accueil.php';
}

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

function afficherPageProfil()
{
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['utilisateur'])) {
        // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
        header('Location: index.php?action=afficherPageConnexion');
        exit;
    }

    $requeteUtilisateurs = ModeleUtilisateurs::obtenirUtilisateur($_SESSION['utilisateur']['nomUtilisateur']);
    $utilisateur = $requeteUtilisateurs->fetch();

    require 'vue/profil.php';
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

    $requeteUtilisateurs = ModeleUtilisateurs::obtenirUtilisateur($_POST['nomUtilisateur']);
    $utilisateur = $requeteUtilisateurs->fetch();
    
        var_dump($utilisateur);
    exit;
    if (!$utilisateur || 
    !password_verify($_POST['motDePasse'], $utilisateur['mot_de_passe'])
    ) {
        $_SESSION['erreurs'] = ['Nom d\'utilisateur ou mot de passe incorrect.'];
        header('Location: index.php?action=afficherPageConnexion');
        exit;
    }

    // Stocker les informations de l'utilisateur dans la session
    $_SESSION['utilisateur'] = [
        'nomUtilisateur' => $_POST['nomUtilisateur'],
        // Ne jamais stocker le mot de passe en clair
    ];

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

    // Ajout de l'utilisateur dans la base de données
    try{
        $motDePasseHache = password_hash($_POST['motDePasse'], PASSWORD_DEFAULT);
        ModeleUtilisateurs::ajouterUtilisateur($_POST['nomUtilisateur'], $motDePasseHache);
        connecter();
    } catch (PDOException $e) {
        $_SESSION['erreurs'] = ['Le nom d\'utilisateur est déjà pris.'];
        header('Location: index.php?action=afficherPageInscription');
        exit;
    }

    // Rediriger vers la page du profil après une inscription réussie
    header('Location: index.php?action=afficherPageProfil');
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

// Fonction pour valider une URL. Fonctionne avec les URL contenant des caractères spéciaux comme les accents.
function validerUrl(string $url) {
    $path = parse_url($url, PHP_URL_PATH);
    $encoded_path = array_map('urlencode', explode('/', $path));
    $url = str_replace($path, implode('/', $encoded_path), $url);

    return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
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
            $_SESSION['utilisateur']['nomUtilisateur'],
            $_POST['nomUtilisateur'],
            empty($_POST['email']) ? null : $_POST['email'],
            empty($_POST['image']) ? null : $_POST['image'] 
        );

        $_SESSION['utilisateur']['nom'] = $_POST['nomUtilisateur'];
        $_SESSION['utilisateur']['email'] = $_POST['email'] ?? '';
        $_SESSION['utilisateur']['image'] = $_POST['image'] ?? '';

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
