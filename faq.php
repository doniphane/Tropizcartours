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


?>

<?php include('navbar.php');  ?>

<br>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>FAQ - Location de Voitures</title>
    <link rel="stylesheet" href="css/faq.css">
</head>

<body>
    <div class="faq-section">
        <h1>Foire aux Questions (FAQ) - Location de Voitures</h1>

        <div class="accordion-container">
            <button class="accordion">Comment puis-je réserver une voiture ?</button>
            <div class="panel">
                <p>Vous pouvez réserver une voiture directement sur notre site web en choisissant vos dates, le modèle de voiture souhaité et en fournissant les informations nécessaires.</p>
            </div>
        </div>

        <div class="accordion-container">
            <button class="accordion">Quels documents sont nécessaires pour louer une voiture ?</button>
            <div class="panel">
                <p>Un permis de conduire valide, une pièce d'identité et une carte de crédit sont généralement requis pour la location d'une voiture.</p>
            </div>
        </div>

        <div class="accordion-container">
            <button class="accordion">Quelle est votre politique en matière de carburant ?</button>
            <div class="panel">
                <p>Les véhicules sont fournis avec un plein de carburant et doivent être retournés dans le même état. Des frais supplémentaires peuvent s'appliquer si le réservoir n'est pas plein au retour.</p>
            </div>
        </div>

        <div class="accordion-container">
            <button class="accordion">Quelles options supplémentaires proposez-vous et à quels coûts ?</button>
            <div class="panel">
                <p>Nous offrons diverses options pour améliorer votre expérience de location, telles que la location de GPS, de sièges enfants. Les coûts varient selon les options et la durée de la location. </p>
            </div>
        </div>




    </div>

    <script src="./js/faq.js"></script>
</body>

</html>