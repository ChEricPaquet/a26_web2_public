<?php $titreOnglet = 'Nouvel Article'; ?>
<?php ob_start(); ?>

<link rel="stylesheet" href="style/nouvelArticle.css">

<h1 class="fw-bold text-center">Nouvel Article</h1>

<div class="card-body p-4 pt-1">
    <?php
    if (isset($_SESSION['erreurs'])) {
        // Récupère les erreurs et les formate pour l'affichage
        $erreurs = implode("<br>", $_SESSION['erreurs']);
        // htmlspecialchars n'est pas nécessaire ici car les erreurs sont générées en interne
        // Affiche les erreurs dans une alerte Bootstrap
        echo '<div class="alert alert-danger" role="alert">' . $erreurs . '</div>';
        // Supprime les erreurs de la session après les avoir affichées
        unset($_SESSION['erreurs']);
    }
    ?>
    <form action="index.php?action=ajouterArticle" method="post" id="formulaireArticle" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="titre" class="form-label fw-semibold">Titre de l'article <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="titre" name="titre" maxlength="255" required placeholder="Ex: Les nouvelles tendances du développement web en 2026">
            <div class="invalid-feedback">Le titre est obligatoire (maximum 255 caractères).</div>
        </div>

        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="resume" class="form-label fw-semibold mb-0">Résumé <span class="text-danger">*</span></label>
                <span id="resumeCompteur" class="compteur-caracteres text-muted">0 / 4096</span>
            </div>
            <textarea class="form-control" id="resume" name="resume" rows="3" maxlength="4096" required placeholder="Aperçu court qui apparaîtra dans les cartes d'articles..."></textarea>
            <div class="invalid-feedback">Le résumé est obligatoire (maximum 4096 caractères).</div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold d-flex justify-content-between align-items-center">
                <span>Images de l'article</span>
                <button type="button" class="btn btn-sm btn-outline-primary" id="btnAjouterImage">
                    <i class="bi bi-plus-lg me-1"></i>Ajouter une image
                </button>
            </label>
            <p class="small text-muted mb-2">Saisissez une ou plusieurs URLs d'images. La première image sera utilisée comme image principale de la carte.</p>
            <div id="imagesConteneur" class="d-flex flex-column gap-2">
            </div>
        </div>

        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="contenu" class="form-label fw-semibold mb-0">Contenu complet <span class="text-danger">*</span></label>
                <span id="contenuCompteur" class="compteur-caracteres text-muted">0 / 65&nbsp;535</span>
            </div>
            <textarea class="form-control" id="contenu" name="contenu" rows="6" required placeholder="Rédigez le contenu complet de votre article ici..." maxlength="65535"></textarea>
            <div class="invalid-feedback">Le contenu complet de l'article est obligatoire (maximum 65&nbsp;535 caractères).</div>
        </div>

        <button type="submit" class="btn btn-primary px-4">Publier l'article</button>

    </form>
</div>

<script src="js/nouvelArticle.js"></script>

<?php $contenu = ob_get_clean(); ?>
<?php require 'vue/gabarit.php'; ?>