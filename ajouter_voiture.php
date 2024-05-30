<?php
session_start();

// Vérifier si l'utilisateur est connecté et a le rôle d'admin
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "admin") {
    header("location: login.php");
    exit;
}

require_once "db.php"; // Inclure le fichier de connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $marque = filter_input(INPUT_POST, 'marque', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $modele = filter_input(INPUT_POST, 'modele', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $annee = filter_input(INPUT_POST, 'annee', FILTER_SANITIZE_NUMBER_INT);
    $prix_par_jour = filter_input(INPUT_POST, 'prix_par_jour', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nombre_de_places = filter_input(INPUT_POST, 'nombre_de_places', FILTER_SANITIZE_NUMBER_INT);
    $type_de_carburant = filter_input(INPUT_POST, 'type_de_carburant', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $transmission = filter_input(INPUT_POST, 'transmission', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Valider les données (exemple : l'année doit être une valeur raisonnable)
    if (!isset($annee) || $annee < 1900 || $annee > date("Y")) {
        die("Année invalide.");
    }

    // Traitement de l'image téléchargée
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Vérifier si le fichier est une image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "Le fichier n'est pas une image.";
        $uploadOk = 0;
    }

    // Vérifier si le fichier existe déjà
    if (file_exists($target_file)) {
        echo "Désolé, le fichier existe déjà.";
        $uploadOk = 0;
    }

    // Vérifier la taille du fichier
    if ($_FILES["image"]["size"] > 5000000) { // 5MB
        echo "Désolé, votre fichier est trop volumineux.";
        $uploadOk = 0;
    }

    // Autoriser certains formats de fichier
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "Désolé, seuls les fichiers JPG, JPEG et PNG sont autorisés.";
        $uploadOk = 0;
    }

    // Vérifier si $uploadOk est mis à 0 par une erreur
    if ($uploadOk == 0) {
        echo "Désolé, votre fichier n'a pas été téléchargé.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Préparation de la requête d'insertion
            $sql = "INSERT INTO voitures (marque, modele, annee, prix_par_jour, image_path, description, nombre_de_places, type_de_carburant, transmission) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            if ($stmt = $pdo->prepare($sql)) {
                
                $stmt->bindParam(1, $marque);
                $stmt->bindParam(2, $modele);
                $stmt->bindParam(3, $annee);
                $stmt->bindParam(4, $prix_par_jour);
                $stmt->bindParam(5, $target_file);
                $stmt->bindParam(6, $description);
                $stmt->bindParam(7, $nombre_de_places);
                $stmt->bindParam(8, $type_de_carburant);
                $stmt->bindParam(9, $transmission);

                // Exécution de la requête
                if ($stmt->execute()) {
                    echo "Nouvelle voiture ajoutée avec succès.";
                } else {
                    echo "Erreur lors de l'ajout de la voiture.";
                }

                // Fermeture du statement
                unset($stmt);
            }
        } else {
            echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
        }
    }

    // Fermeture de la connexion
    unset($pdo);
}
