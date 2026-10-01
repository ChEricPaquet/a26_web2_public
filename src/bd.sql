CREATE DATABASE IF NOT EXISTS `exercice_bd_supplementaire`
    DEFAULT CHARACTER SET utf8mb4
    COLLATE utf8mb4_0900_ai_ci;

USE `exercice_bd_supplementaire`;
SET default_storage_engine=InnoDB;

-- Table des utilisateurs
CREATE TABLE `utilisateurs` (
    `id` int NOT NULL AUTO_INCREMENT,
    `nom` varchar(45) NOT NULL,
    `mot_de_passe` varchar(255) NOT NULL,
    `email` varchar(255) DEFAULT NULL,
    `image` varchar(2048) DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE (`nom`)
);

INSERT INTO `utilisateurs` (`id`, `nom`, `mot_de_passe`) VALUES
    (1, 'admin', '$2y$12$uGwARXPnomr0u/OtCTBNzeKlhpURriaiDBQJZm.rY0TqN0Hk9x/VO'); -- Mot de passe haché pour '123456'

INSERT INTO `utilisateurs` (`id`, `nom`, `mot_de_passe`, `email`, `image`) VALUES
    (2, 'user1', '$2y$12$aCX4MDnlrfoHgS5BDmQ8Me/mfO37WpHdbMtgj1s8Ul5EtceePi/mi', 'user1@example.com', 'https://placehold.co/42'); -- Mot de passe haché pour 'password1'

-- Table des articles
CREATE TABLE `articles` (
    `id` int NOT NULL AUTO_INCREMENT,
    `titre` varchar(255) NOT NULL,
    `resume` varchar(4096) NOT NULL,
    `contenu` text NOT NULL,
    `date_publication` datetime NOT NULL DEFAULT UTC_TIMESTAMP,
    `utilisateur_id` int NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs`(`id`) ON DELETE CASCADE
);

INSERT INTO `articles` (`id`, `titre`, `resume`, `contenu`, `date_publication`, `utilisateur_id`) VALUES
    (1, 'Premier article', 'Ceci est le résumé du premier article.', 'Ceci est le contenu du premier article.', DATE_ADD(UTC_TIMESTAMP(), INTERVAL -2 DAY), 1),
    (2, 'Deuxième article', 'Ceci est le résumé du deuxième article.', 'Ceci est le contenu du deuxième article.', DATE_ADD(UTC_TIMESTAMP(), INTERVAL -1 DAY), 2),
    (3, 'Troisième article', 'Ceci est le résumé du troisième article.', 'Ceci est le contenu du troisième article.', DEFAULT, 1); -- Utilisation de la valeur par défaut (date et heure actuelles) pour la date de création

-- Table des images des articles
CREATE TABLE `images_articles` (
    `id` int NOT NULL AUTO_INCREMENT,
    `url` varchar(2048) NOT NULL,
    `article_id` int NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`article_id`) REFERENCES `articles`(`id`) ON DELETE CASCADE
);

INSERT INTO `images_articles` (`id`, `url`, `article_id`) VALUES
    (1, 'https://picsum.photos/800/400', 1),
    (2, 'https://picsum.photos/400/800', 1),
    (3, 'https://picsum.photos/600/600', 2);


-- Requête pour récupérer tous les articles avec leurs images
SELECT
    a.*,
    COALESCE(
        (
            SELECT JSON_ARRAYAGG(ia.url)
            FROM images_articles ia
            WHERE ia.article_id = a.id
        ),
        JSON_ARRAY()
    ) AS images
FROM articles a;

-- Requête pour récupérer un article spécifique avec le nom de l'auteur et toutes ses images
SELECT
    a.*,
    u.nom AS auteur_nom,
    COALESCE(
        (
            SELECT JSON_ARRAYAGG(ia.url)
            FROM images_articles ia
            WHERE ia.article_id = a.id
        ),
        JSON_ARRAY()
    ) AS images
FROM articles a
INNER JOIN utilisateurs u ON a.utilisateur_id = u.id
WHERE a.id = 1;
