<?php
require_once "db.php";

if (isset($_GET['id'])) {
    $id_voiture = $_GET['id'];

    
    $sql = "DELETE FROM voitures WHERE id_voiture = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_voiture]);

   
    header("Location: admin_dashboard.php");
    exit();
}
?>
