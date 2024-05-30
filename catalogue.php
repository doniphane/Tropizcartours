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

// Pagination
$voituresParPage = 4;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);
$debut = ($page - 1) * $voituresParPage;

// Validation de l'entrée de la page pour s'assurer qu'elle est numérique et positive
if (filter_var($page, FILTER_VALIDATE_INT) === false || $page < 1) {
    $page = 1;
}

// Calcule le nombre total de pages
$sql = "SELECT COUNT(*) FROM voitures";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$totalVoitures = $stmt->fetchColumn();
$totalPages = ceil($totalVoitures / $voituresParPage);

$sql = "SELECT * FROM voitures LIMIT :debut, :voituresParPage";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":debut", $debut, PDO::PARAM_INT);
$stmt->bindValue(":voituresParPage", $voituresParPage, PDO::PARAM_INT);
$stmt->execute();
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Catalogue des Voitures</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/catalogue.css">
</head>

<body>

    <?php include('navbar.php');  ?>
    <div>
        <h1>Catalogue des Voitures</h1>
        <p class="titre1">Parcourez notre collection de voitures disponibles pour la location.</p>
        <br>
        <div class="catalogue-grid">
            <?php
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='card'>";
                echo '<img src="' . htmlspecialchars($row['image_path']) . '" alt="Image de la voiture">';
                echo "<div class='card-body'>";
                echo "<h3 class='card-title'>" . htmlspecialchars($row['marque']) . " " . htmlspecialchars($row['modele']) . "</h3>";
                echo "<p class='card-text'>Prix par jour: " . htmlspecialchars($row['prix_par_jour']) . "€</p>";
                echo "<a href='details_voiture.php?id=" . htmlspecialchars($row['id_voiture']) . "' class='card-btn'>Voir détails</a>";
                echo "</div></div>";
            }
            ?>

        </div>


        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <a href="?page=<?= $i; ?>" class="<?= $page === $i ? 'active' : '' ?>"><?= $i; ?></a>
            <?php endfor; ?>
        </div>
    </div>
</body>

</html>