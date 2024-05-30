<?php
require_once "db.php"; 


function voitureEstDisponible($pdo, $voitureId, $dateDebut, $dateFin)
{
    
    $query = "SELECT COUNT(*) FROM locations 
              WHERE id_voiture = :voitureId 
              AND NOT (date_fin < :dateDebut OR date_debut > :dateFin)";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":voitureId", $voitureId, PDO::PARAM_INT);
    $stmt->bindParam(":dateDebut", $dateDebut);
    $stmt->bindParam(":dateFin", $dateFin);
    $stmt->execute();

   
    return $stmt->fetchColumn() == 0;
}


if (isset($_POST['voitureId'], $_POST['dateDebut'], $_POST['dateFin'])) {
    $voitureId = $_POST['voitureId'];
    $dateDebut = $_POST['dateDebut'];
    $dateFin = $_POST['dateFin'];

  
    if (voitureEstDisponible($pdo, $voitureId, $dateDebut, $dateFin)) {
        echo 'disponible'; 
    } else {
        echo 'indisponible'; 
    }
} else {
 
    echo 'erreur';
}
