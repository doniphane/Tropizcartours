<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once "db.php";

if (!isset($_SESSION["id_utilisateur"])) {
    header("location: erreur.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $voitureId = htmlspecialchars(strip_tags(trim($_POST["voiture_id"])));
    $dateDebut = htmlspecialchars(strip_tags(trim($_POST["date_debut"])));
    $dateFin = htmlspecialchars(strip_tags(trim($_POST["date_fin"])));
    $prixTotal = htmlspecialchars(strip_tags(trim($_POST["prix_total"])));
    $prixTotal = floatval(str_replace('€', '', $prixTotal)); 
    $nomUtilisateur = htmlspecialchars(strip_tags(trim($_POST["nom_utilisateur"])));
    $emailUtilisateur = htmlspecialchars(strip_tags(trim($_POST["email_utilisateur"])));
    $locationId = htmlspecialchars(strip_tags(trim($_POST["location_id"])));
   

  

    $query = "INSERT INTO locations (id_voiture, id_utilisateur, date_debut, date_fin, prix_total, nom_utilisateur, email_utilisateur, location_id, etat_commande) 
          VALUES (:voitureId, :utilisateurId, :dateDebut, :dateFin, :prixTotal, :nomUtilisateur, :emailUtilisateur, :locationId, 'En attente')";


    if ($stmt = $pdo->prepare($query)) {
        $stmt->bindParam(":voitureId", $voitureId, PDO::PARAM_INT);
        $stmt->bindParam(":utilisateurId", $_SESSION["id_utilisateur"], PDO::PARAM_INT);
        $stmt->bindParam(":dateDebut", $dateDebut);
        $stmt->bindParam(":dateFin", $dateFin);
        $stmt->bindParam(":prixTotal", $prixTotal);
        $stmt->bindParam(":nomUtilisateur", $nomUtilisateur);
        $stmt->bindParam(":emailUtilisateur", $emailUtilisateur);
        $stmt->bindParam(":locationId", $locationId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("location: confirmation_commande.php");
            exit;
        } else {
            echo "Une erreur est survenue. Veuillez réessayer plus tard.";
        }
    }
    unset($stmt);
}
