<?php

session_start();


if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once "auth_check.php";


if (!checkUserRole('user')) {
    header("location: index.php");
    exit;
}


require_once "db.php";


if ($pdo === null) {
    die("Erreur de connexion à la base de données.");
}


$sql = "SELECT l.id_location, v.marque, v.modele, l.date_debut, l.date_fin, l.prix_total,  l.email_utilisateur, l.etat_commande
        FROM locations l
        
        JOIN voitures v ON v.id_voiture = l.id_voiture 
        WHERE l.id_utilisateur = :id_utilisateur";

try {
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":id_utilisateur", $_SESSION["id_utilisateur"], PDO::PARAM_INT);

    $stmt->execute();
} catch (PDOException $e) {
    die("Erreur lors de l'exécution de la requête : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Vos Commandes</title>
    <!-- Inclusion de Tailwind CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <?php include('navbar.php'); ?>
    <div class="max-w-4xl mx-auto px-2 py-8">
        <h1 class="text-3xl font-bold text-center mb-8">Historique de vos Commandes</h1>

        <?php if ($stmt->rowCount() > 0) : ?>
            <div class="overflow-x-auto">
                <table class="table-auto w-full">
                    <thead class="bg-blue-200">
                        <tr>
                            <th class="px-2 py-1 text-xs">Commande N°</th>
                            <th class="px-2 py-1 text-xs">Voiture</th>
                            <th class="px-2 py-1 text-xs">Date de début</th>
                            <th class="px-2 py-1 text-xs">Date de fin</th>
                            <th class="px-2 py-1 text-xs">Prix total</th>
                            <th class="px-2 py-1 text-xs">Adresse e-mail</th>
                            <th class="px-2 py-1 text-xs">Etat de la commande</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
                            <tr class="bg-white border-b">
                                <td class="px-2 py-2"><?= htmlspecialchars($row['id_location']) ?></td>
                                <td class="px-2 py-2"><?= htmlspecialchars($row['marque']) . " " . htmlspecialchars($row['modele']) ?></td>
                                <td class="px-2 py-2"><?= htmlspecialchars($row['date_debut']) ?></td>
                                <td class="px-2 py-2"><?= htmlspecialchars($row['date_fin']) ?></td>
                                <td class="px-2 py-2"><?= htmlspecialchars($row['prix_total']) ?>€</td>
                                <td class="px-2 py-2"><?= htmlspecialchars($row['email_utilisateur'] ?? '') ?></td>
                                <td class="px-2 py-2"><?= htmlspecialchars($row['etat_commande'] ?? '') ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <p class="text-center">Vous n'avez pas encore passé de commande.</p>
        <?php endif; ?>
    </div>
</body>

</html>