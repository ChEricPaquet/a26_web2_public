<?php $titreOnglet = 'Le titre de l\'article;' ?>
<?php ob_start(); ?>

<link rel="stylesheet" href="style/articleDetail.css">

<div class="container py-4">
    <div class="mb-4">
        <a href="index.php?action=afficherPageArticles" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Retour aux articles
        </a>
    </div>

    <article class="bg-white p-4 p-md-5 rounded shadow-sm">
        <h1 class="fw-bold mb-3">Le titre de l'article;</h1>

        <div class="d-flex align-items-center text-muted mb-4 pb-3 border-bottom gap-3">
            <div>
                <i class="bi bi-person-circle"></i>
                <strong>Le nom de l'auteur</strong>
            </div>
            <div>•</div>
            <div>
                <i class="bi bi-calendar3"></i> Publié le
                <?php
                $dateAuFormatDeLaBaseDeDonnees = '2008-08-08 8:08:08';
                $dateUtcIso = date('Y-m-d\TH:i:s\Z', strtotime($dateAuFormatDeLaBaseDeDonnees));
                ?>
                <time class="date-locale fw-medium" datetime="<?php echo $dateUtcIso; ?>">
                    2008-08-08 8:08:08
                </time>
            </div>
        </div>

        <?php $images = ['https://picsum.photos/400/400', 'https://picsum.photos/600/600'] ?>
        <?php if (!empty($images)) { ?>
            <div id="carouselArticle" class="carousel slide mb-4 rounded overflow-hidden shadow-sm" data-bs-ride="carousel">
                <?php if (count($images) > 1) { ?>
                    <div class="carousel-indicators">
                        <?php foreach ($images as $index => $imgUrl) { ?>
                            <button type="button" data-bs-target="#carouselArticle" data-bs-slide-to="<?php echo $index; ?>" class="<?php echo $index === 0 ? 'active' : ''; ?>" aria-label="Image <?php echo $index + 1; ?>"></button>
                        <?php } ?>
                    </div>
                <?php } ?>

                <div class="carousel-inner">
                    <?php foreach ($images as $index => $imgUrl) { ?>
                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                            <img src="<?php echo htmlspecialchars($imgUrl); ?>" class="d-block w-100 object-fit-cover" style="max-height: 500px;" alt="Image article">
                        </div>
                    <?php } ?>
                </div>

                <?php if (count($images) > 1) { ?>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselArticle" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Précédent</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselArticle" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Suivant</span>
                    </button>
                <?php } ?>
            </div>
        <?php } ?>

        <p class="lead text-secondary fw-semibold border-start border-4 border-primary ps-3 my-4">
            Le resumé de l'article.
        </p>

        <div class="article-content fs-5 lh-lg">
            Le contenu complet de l'article.
        </div>
    </article>
</div>

<script src="js/utcVersLocal.js"></script>

<?php $contenu = ob_get_clean(); ?>
<?php require 'vue/gabarit.php'; ?>