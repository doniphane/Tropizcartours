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

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Bienvenue</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/user.css">
    <link rel="stylesheet" href="css/faq.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" crossorigin="anonymous">

</head>

<body>

    <?php include('navbar.php');  ?>
    <div>


        <div class="header">
            <img src="./img/Header.png" alt="Header Image" />
            <p class="header-text">
                Atterrissez et embarquez dans une expérience unique ! Choisissez la location de voiture parfaite pour une exploration sans limites.
            </p>
            <a href="catalogue.php" class="header-button">Commander</a>
        </div>

        <div>
            <div class="titre-principal">Découvrez la liberté de voyager à la Réunion avec une voiture de location !</div>
            <p class="sous-titre">
                Explorer l'île de la Réunion à votre rythme est désormais facile et abordable. <span class='gras'>Réservez en ligne votre voiture avec TropizzCarTours et bénéficiez des meilleurs tarifs</span>
            </p>
        </div>

        <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">

            <div class="carousel-inner">
                <div class="carousel-item active" data-interval="2000">
                    <img class="mx-auto d-block" src="./img/20.png" alt="First slide" style="max-width: 900px;">
                </div>
                <div class="carousel-item" data-interval="2000">
                    <img class="mx-auto d-block" src="./img/2.jpeg" alt="Second slide" style="max-width: 900px;">
                </div>
                <div class="carousel-item" data-interval="2000">
                    <img class="mx-auto d-block" src="./img/4.jpeg" alt=" slide" style="max-width: 900px;">
                </div>
            </div>
        </div>

        <div class="container">

            <div>
                <div class="titre-principal">Bienvenue sur TropizzCars</div>
                <p class="sous-titre">
                    TropizzCars est votre solution de location de voitures à la Réunion, conçue spécialement pour rendre votre séjour sur l'île inoubliable. Nous sommes là pour vous offrir la liberté de découvrir cette île magnifique à votre propre rythme, en toute simplicité.
                </p>
            </div>

            <div class="container">
                <div class="titre-principal">
                    Pourquoi choisir TropizzCars ?
                </div>

                <div class="conteneur-etapes">
                    <div class="etape">
                        <div class="titre-etape">Explorez en toute tranquillité</div>
                        <p class="texte-etape2">
                            Chez TropizzCars, nous nous occupons de tout pour que vous puissiez profiter pleinement de votre séjour. Nous offrons une prise en charge personnalisée à l'aéroport ou au port, une assistance 24/7, et des assurances incluses pour votre tranquillité d'esprit.
                        </p>
                    </div>

                    <div class="etape">
                        <div class="titre-etape">Une flotte variée et récente</div>
                        <p class="texte-etape2">
                            Notre flotte de véhicules récents est adaptée à tous les goûts et besoins. Que vous voyagiez en solo, en couple ou en famille, vous trouverez la voiture parfaite pour votre aventure à la Réunion. Avec un kilométrage illimité, explorez chaque coin de l'île sans contrainte.
                        </p>
                    </div>

                    <div class="etape">
                        <div class="titre-etape">Flexibilité et disponibilité</div>
                        <p class="texte-etape2">
                            Nous sommes là pour vous 7 jours sur 7, y compris les jours fériés, pour vous offrir une flexibilité maximale. Notre agence est située à proximité de l'aéroport de Saint-Denis, prête à vous accueillir dès votre arrivée. Nous proposons également des équipements additionnels pour votre confort, comme des sièges pour enfants et des rehausseurs.
                        </p>
                    </div>
                </div>
            </div>


            <div class="titre-principal">
                Vivez une aventure inoubliable à la Réunion avec TropizzCarTours
            </div>

            <div class="conteneur-etapes">
                <div class="etape">
                    <div class="titre-etape">Les avantages exclusifs chez TropizzCarTours</div>
                    <p class="texte-etape2">
                    <p><i class="fas fa-car"></i> Accueil et prise en charge personnalisée à l'aéroport ou au port <br></p>
                    <p><i class="fas fa-road"></i> Kilométrage illimité pour une exploration sans limites, assurances incluses pour votre tranquillité d'esprit <br></p>
                    <p> <i class="fas fa-hands-helping"></i> Assistance disponible 24/7 pour une expérience sans tracas <br></p>
                    <p><i class="fas fa-car-side"></i> Une gamme variée de véhicules récents adaptés à tous les goûts et besoins <br></p>
                    <p><i class="far fa-calendar-alt"></i> Disponibilité totale 7j/7, y compris les jours fériés pour une flexibilité maximale</p>
                    </p>
                </div>

                <div class="etape">
                    <p class="texte-etape">
                    <p>Chez TropizzCarTours, nous comprenons que chaque voyage est unique. </p>
                    <p>C'est pourquoi notre offre de location de voitures inclut un large éventail d'options pour personnaliser votre expérience de conduite.</p>
                    <p>Avec un kilométrage illimité, vous êtes libre d'explorer chaque recoin de l'île sans contrainte. Notre flotte, composée de véhicules récents et bien entretenus, est là pour garantir sécurité et confort, que vous voyagiez seul, en couple, ou en famille.</p>
                    <p>Située à proximité de l'aéroport de Saint-Denis, notre agence est prête à vous accueillir dès votre arrivée. Nous sommes dédiés à vous fournir un service rapide, efficace et personnalisé, vous permettant de commencer votre aventure sans délai.</p>
                    <p>De plus, nous proposons des équipements additionnels tels que des sièges pour enfants, des rehausseurs. Notre engagement envers la qualité et la satisfaction client se reflète dans notre excellent rapport qualité/prix.</p>
                    <p>Chez TropizzCarTours, votre expérience à la Réunion est notre priorité. Laissez-nous vous accompagner dans cette aventure mémorable !</p>
                    </p>
                </div>
            </div>
        </div>

        <?php
        require_once 'db.php';

        $sql = "SELECT * FROM voitures ORDER BY RAND() LIMIT 5";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo "<h2>Voitures Vedettes</h2>";

                echo "<div class='voitures-vedettes'>";
                while ($row = $stmt->fetch()) {
                    echo "<div class='voiture-carte'>";
                    echo "<img src='" . $row['image_path'] . "' alt='" . $row['marque'] . " " . $row['modele'] . "'>";
                    echo "<h3>" . htmlspecialchars($row['marque']) . " " . htmlspecialchars($row['modele']) . "</h3>";
                    echo "<p>Année : " . htmlspecialchars($row['annee']) . "</p>";
                    echo "<p>Prix par jour : " . htmlspecialchars($row['prix_par_jour']) . " EUR</p>";

                    echo '<a class="bouton-detail" href="catalogue.php">Voir plus</a>';
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "Aucune voiture disponible.";
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
        ?>


    </div>
    </p>
    </div>

    <footer class="footer-container">
        <div class="footer-section">
            <h3>TropizzCarTours</h3>
        </div>

        <div class="footer-section">

            <div class="project-notice">
                <h3>Note sur le projet</h3>
                <p>
                    Ce site web est un projet fictif développé dans le cadre d'une soutenance de fin de formation. Les informations présentes sur ce site, y compris les adresses, numéros de téléphone, et détails de l'entreprise, sont purement imaginaires et utilisées uniquement à des fins de démonstration et d'évaluation académique. Ce projet n'a pas pour but d'être utilisé dans un contexte commercial ou professionnel réel.
                </p>
            </div>
            <ul>
                <li><a href="./mentionlegale.php">Mentions légales</a></li>
                <li><a href="./PolitiqueConfidentialité.php">Politique de confidentialité</a></li>

            </ul>

            <p>Site réaliser par Trules Doniphane </p>
        </div>
    </footer>

</body>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/js/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>


</html>