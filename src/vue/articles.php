<?php
/** @var \PDOStatement|false $requeteArticles */
assert(isset($requeteArticles), 'La variable $requeteArticles doit être définie.');
assert($requeteArticles instanceof \PDOStatement || $requeteArticles === false, 'La variable $requeteArticles doit être une instance de PDOStatement ou false.');
?>
<?php $titreOnglet = 'Articles'; ?>
<?php ob_start(); ?>

<link rel="stylesheet" href="style/articles.css">

<h1 class="fw-bold text-center mb-4">Articles</h1>

<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">

    <?php while ($article = $requeteArticles->fetch()) { ?>
        <?php 
            // Décodage du tableau d'images JSON
            $article['images'] = json_decode($article['images'], true); 
            
            // Image principale ou image par défaut
            $imageSource = !empty($article['images'][0]) 
                ? $article['images'][0] 
                : 'https://placehold.net/default.svg';
            
            // Formatage de la date pour le composant d'affichage local
            $dateUtcIso = date('Y-m-d\TH:i:s\Z', strtotime($article['date_publication'])); 
        ?>

        <div class="col">
            <div class="card h-100 shadow-sm">
                <img src="<?php echo htmlspecialchars($imageSource); ?>" class="card-img-top card-img-fixed" alt="<?php echo htmlspecialchars($article['titre']); ?>">
                <div class="card-body d-flex flex-column">
                    <div class="text-muted small mb-2">
                        <i class="bi bi-calendar"></i> Publié le
                        <time class="date-locale" datetime="<?php echo $dateUtcIso; ?>">
                            <?php echo htmlspecialchars($article['date_publication']); ?>
                        </time>
                    </div>
                    <h5 class="card-title card-title-fixed"><?php echo htmlspecialchars($article['titre']); ?></h5>
                    <p class="card-text text-muted flex-grow-1"><?php echo htmlspecialchars($article['resume']); ?></p>
                    <a href="index.php?action=afficherPageArticles&articleId=<?php echo $article['id']; ?>" class="btn btn-primary mt-auto">Lire l'article</a>
                </div>
            </div>
        </div>
    <?php } ?>

</div>

<script src="js/utcVersLocal.js"></script>

<?php $contenu = ob_get_clean(); ?>
<?php require 'vue/gabarit.php'; ?>