<?php

function afficherPageArticles()
{
    require 'vue/articles.php';
}

function afficherPageNouvelArticle()
{
    require 'vue/nouvelArticle.php';
}

function validerDonneesAjouterArticle()
{
    $erreurs = [];
    if (empty($_POST['titre']) || mb_strlen($_POST['titre']) > 255) {
        $erreurs[] = 'Le titre est obligatoire (maximum 255 caractères).';
    }
    if (empty($_POST['resume']) || mb_strlen($_POST['resume']) > 4096) {
        $erreurs[] = 'Le résumé est obligatoire (maximum 4096 caractères).';
    }
    if (empty($_POST['contenu']) || mb_strlen($_POST['contenu']) > 65535) {
        $erreurs[] = 'Le contenu est obligatoire (maximum 65535 caractères).';
    }
    if (isset($_POST['images'])) {
        if (!is_array($_POST['images'])) {
            $erreurs[] = 'Les images doivent être un tableau.';
        } else {
            foreach ($_POST['images'] as $urlImage) {
                if (empty($urlImage)) {
                    $erreurs[] = 'L\'URL de l\'image ne peut pas être vide.';
                } elseif (!filter_var($urlImage, FILTER_VALIDATE_URL)) {
                    $erreurs[] = 'L\'URL de l\'image n\'est pas valide : ' . htmlspecialchars($urlImage);
                }
            }
        }
    }
    return $erreurs;
}

function ajouterArticle()
{
    $erreurs = validerDonneesAjouterArticle();
    if (!empty($erreurs)) {
        $_SESSION['erreurs'] = $erreurs;
        header('Location: index.php?action=afficherPageNouvelArticle');
        exit;
    }

    header('Location: index.php?action=afficherPageArticles');
}