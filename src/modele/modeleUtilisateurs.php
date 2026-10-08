<?php 
    require_once 'modele/bd.php';

    class ModeleUtilisateurs
    {
        public static function obtenirUtilisateur(string $nom)
        {
            $connexion = BD::ObtenirConnexion();

            $req = $connexion->prepare(
                "SELECT * FROM utilisateurs WHERE nom = :nom"
            );

            $req->bindParam(':nom', $nom);

            $req->execute();

            return $req;
        }

        public static function ajouterUtilisateur(string $nom, string $motDePasse)
        {
            $connexion = BD::ObtenirConnexion();

            $req = $connexion->prepare(
                "INSERT INTO utilisateurs (nom, mot_de_passe) VALUES (:nom, :motDePasse)"
            );

            $req->bindParam(':nom', $nom);
            $req->bindParam(':motDePasse', $motDePasse);

            return $req->execute();
        }

        public static function mettreAJourUtilisateur(string $ancienNom, string $nouveauNom, string|null $email, string|null $image)
        {
        $connexion = BD::ObtenirConnexion();

        // Préparation de la requête SQL avec des paramètres nommés
        $req = $connexion->prepare(
            "UPDATE utilisateurs 
            SET nom = :nouveauNom, email = :email, image = :image
            WHERE nom = :ancienNom"
        );

        // Liaison des paramètres nommés avec les variables PHP
        $req->bindParam(':ancienNom', $ancienNom);
        $req->bindParam(':nouveauNom', $nouveauNom);
        $req->bindParam(':email', $email);
        $req->bindParam(':image', $image);

        // Exécution de la requête préparée
        return $req->execute();
    }
    }
?>