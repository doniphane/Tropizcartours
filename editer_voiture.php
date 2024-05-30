<?php
session_start();
require_once "db.php";
require_once "auth_check.php";

// Vérification de l'accès administrateur
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !checkUserRole('admin')) {
    header("location: login.php");
    exit;
}

// Validation de l'ID de la voiture
$id_voiture = isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT) ? $_GET['id'] : null;

if ($id_voiture) {
    // Récupération des détails de la voiture
    $sql = "SELECT * FROM voitures WHERE id_voiture = :id_voiture";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id_voiture", $id_voiture, PDO::PARAM_INT);
    $stmt->execute();
    $voiture = $stmt->rowCount() == 1 ? $stmt->fetch(PDO::FETCH_ASSOC) : null;

    if (!$voiture) {
        header("location: error.php");
        exit;
    }
} else {
    header("location: error.php");
    exit;
}

// Traitement du formulaire de mise à jour
if ($_SERVER["REQUEST_METHOD"] == "POST" && $id_voiture) {
    // Assainissement des données du formulaire
    $marque = trim($_POST['marque']);
    $modele = trim($_POST['modele']);
    $annee = filter_input(INPUT_POST, 'annee', FILTER_VALIDATE_INT);
    $prix_par_jour = filter_input(INPUT_POST, 'prix_par_jour', FILTER_VALIDATE_FLOAT);

    // Gestion de l'upload de l'image
    $imagePath = $voiture['image_path'];
    if (isset($_FILES["image_path"]) && $_FILES["image_path"]["error"] == 0) {
        $allowed = ["jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png"];
        $filename = $_FILES["image_path"]["name"];
        $filetype = $_FILES["image_path"]["type"];
        $filesize = $_FILES["image_path"]["size"];

        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed) || !in_array($filetype, $allowed) || $filesize > 5 * 1024 * 1024) {
            die("Erreur : problème de fichier.");
        }

        $newFilename = uniqid() . ".$ext";
        $imagePath = "uploads/" . $newFilename;
        if (!move_uploaded_file($_FILES["image_path"]["tmp_name"], $imagePath)) {
            die("Erreur lors de l'upload du fichier.");
        }
        // Suppression de l'ancienne image si une nouvelle est uploadée
        if ($imagePath !== $voiture['image_path']) {
            @unlink($voiture['image_path']);
        }
    }

    if ($annee && $prix_par_jour) {
        $sql = "UPDATE voitures SET marque = :marque, modele = :modele, annee = :annee, prix_par_jour = :prix_par_jour, image_path = :image_path WHERE id_voiture = :id_voiture";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':marque' => $marque, ':modele' => $modele, ':annee' => $annee, ':prix_par_jour' => $prix_par_jour, ':image_path' => $imagePath, ':id_voiture' => $id_voiture]);

        if ($stmt) {
            header("Location: admin_dashboard.php");
            exit;
        } else {
            echo "Erreur lors de la mise à jour.";
        }
    } else {
        echo "Données fournies invalides.";
    }
}


?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Éditer Voiture</title>
    <link rel="stylesheet" href="./css/editer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <h2>Éditer Voiture</h2>
    <form action="editer_voiture.php?id=<?= $id_voiture ?>" method="post" enctype="multipart/form-data">
        <label for="marque"><i class="fas fa-car"></i> Marque:</label><br>
        <input type="text" id="marque" name="marque" value="<?= $voiture['marque'] ?>" required><br>

        <label for="modele"><i class="fas fa-car"></i> Modèle:</label><br>
        <input type="text" id="modele" name="modele" value="<?= $voiture['modele'] ?>" required><br>

        <label for="annee"><i class="fas fa-calendar"></i> Année:</label><br>
        <input type="number" id="annee" name="annee" value="<?= $voiture['annee'] ?>" required><br>

        <label for="prix_par_jour"><i class="fas fa-euro-sign"></i> Prix par jour (€):</label><br>
        <input type="text" id="prix_par_jour" name="prix_par_jour" value="<?= $voiture['prix_par_jour'] ?>" required><br>


        <label for="image_path"><i class="fas fa-image"></i> Image de la voiture (jpg, png):</label><br>
        <input type="file" id="image_path" name="image_path" accept=".jpg, .png"><br><br>

        <input type="submit" value="Mettre à jour la voiture">

    </form>
</body>

</html>