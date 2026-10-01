<?php $titreOnglet = 'Articles'; ?>
<?php ob_start(); ?>

<link rel="stylesheet" href="style/articles.css">

<h1 class="fw-bold text-center">Articles</h1>

<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">

    <?php
    $dateAuFormatDeLaBaseDeDonnees = '2026-09-29 20:27:25';
    $dateUtcIso = date('Y-m-d\TH:i:s\Z', strtotime($dateAuFormatDeLaBaseDeDonnees));
    ?>
    <div class="col">
        <div class="card h-100 shadow-sm">
            <img src="https://picsum.photos/800/400" class="card-img-top card-img-fixed" alt="Titre de l'article 1">
            <div class="card-body d-flex flex-column">
                <div class="text-muted small mb-2">
                    <i class="bi bi-calendar"></i> Publié le
                    <time class="date-locale" datetime="<?php echo $dateUtcIso; ?>">
                        2026-09-29 20:27:25
                    </time>
                </div>
                <h5 class="card-title card-title-fixed">Titre court d'article</h5>
                <p class="card-text text-muted flex-grow-1">Petit résumé optionnel de l'article si vous souhaitez en ajouter un.</p>
                <a href="index.php?action=afficherPageArticles&articleId=1" class="btn btn-primary mt-auto">Lire l'article</a>
            </div>
        </div>
    </div>

    <?php
    $dateAuFormatDeLaBaseDeDonnees = '2026-09-15 20:27:25';
    $dateUtcIso = date('Y-m-d\TH:i:s\Z', strtotime($dateAuFormatDeLaBaseDeDonnees));
    ?>
    <div class="col">
        <div class="card h-100 shadow-sm">
            <img src="https://picsum.photos/400/800" class="card-img-top card-img-fixed" alt="Titre de l'article 2">
            <div class="card-body d-flex flex-column">
                <div class="text-muted small mb-2">
                    <i class="bi bi-calendar"></i> Publié le
                    <time class="date-locale" datetime="<?php echo $dateUtcIso; ?>">
                        2026-09-15 20:27:25
                    </time>
                </div>
                <h5 class="card-title card-title-fixed">Un titre d'article beaucoup plus long qui s'étend sur deux lignes entières</h5>
                <p class="card-text text-muted flex-grow-1">Résumé de l'article 2...</p>
                <a href="index.php?action=afficherPageArticles&articleId=2" class="btn btn-primary mt-auto">Lire l'article</a>
            </div>
        </div>
    </div>

    <?php
    $dateAuFormatDeLaBaseDeDonnees = '2026-09-01 20:27:25';
    $dateUtcIso = date('Y-m-d\TH:i:s\Z', strtotime($dateAuFormatDeLaBaseDeDonnees));
    ?>
    <div class="col">
        <div class="card h-100 shadow-sm">
            <img src="https://picsum.photos/600/600" class="card-img-top card-img-fixed" alt="Titre de l'article 3">
            <div class="card-body d-flex flex-column">
                <div class="text-muted small mb-2">
                    <i class="bi bi-calendar"></i> Publié le
                    <time class="date-locale" datetime="<?php echo $dateUtcIso; ?>">
                        2026-09-01 20:27:25
                    </time>
                </div>
                <h5 class="card-title card-title-fixed">Titre moyen pour cet article</h5>
                <p class="card-text text-muted flex-grow-1">Résumé de l'article 3...</p>
                <a href="index.php?action=afficherPageArticles&articleId=3" class="btn btn-primary mt-auto">Lire l'article</a>
            </div>
        </div>
    </div>

    <?php
    $dateAuFormatDeLaBaseDeDonnees = '2026-09-07 20:27:25';
    $dateUtcIso = date('Y-m-d\TH:i:s\Z', strtotime($dateAuFormatDeLaBaseDeDonnees));
    ?>
    <div class="col">
        <div class="card h-100 shadow-sm">
            <img src="https://placehold.net/default.svg" class="card-img-top card-img-fixed" alt="Titre de l'article 4">
            <div class="card-body d-flex flex-column">
                <div class="text-muted small mb-2">
                    <i class="bi bi-calendar"></i> Publié le
                    <time class="date-locale" datetime="<?php echo $dateUtcIso; ?>">
                        2026-09-07 20:27:25
                    </time>
                </div>
                <h5 class="card-title card-title-fixed">Titre moyen pour cet article</h5>
                <p class="card-text text-muted flex-grow-1">Résumé de l'article 4...</p>
                <a href="index.php?action=afficherPageArticles&articleId=4" class="btn btn-primary mt-auto">Lire l'article</a>
            </div>
        </div>
    </div>

</div>

<script src="js/utcVersLocal.js"></script>

<?php $contenu = ob_get_clean(); ?>
<?php require 'vue/gabarit.php'; ?>