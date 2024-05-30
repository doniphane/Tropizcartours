<?php
require_once 'db.php'; // Inclut le fichier de configuration de la base de données

if (isset($_POST['id_location']) && isset($_POST['nouvel_etat'])) {
    $id_location = $_POST['id_location'];
    $nouvel_etat = $_POST['nouvel_etat'];

    try {
        // La variable $pdo est déjà définie et prête à l'emploi grâce à require_once 'db.php'
        $sqlUpdate = "UPDATE locations SET etat_commande = :nouvel_etat WHERE id_location = :id_location";
        $stmt = $pdo->prepare($sqlUpdate);
        $stmt->bindParam(':nouvel_etat', $nouvel_etat, PDO::PARAM_STR);
        $stmt->bindParam(':id_location', $id_location, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: admin_dashboard.php");
        exit();
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
} else {
    echo "Informations nécessaires non fournies.";
}
