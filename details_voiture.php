<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Voir Détails de la Voiture</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/detail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>

    <?php include('navbar.php'); ?>

    <?php
    session_start();
    require_once "db.php";
    require_once "auth_check.php";

    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !checkUserRole('user')) {
        header("location: login.php");
        exit;
    }

    $imagePath = $marque = $modele = $annee = $description = $prix_par_jour = '';
    $row = [];

    if (isset($_GET["id"]) && filter_var($_GET["id"], FILTER_VALIDATE_INT)) {
        $param_id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);

        $sql = "SELECT * FROM voitures WHERE id_voiture = :id";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
            if ($stmt->execute() && $stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $imagePath = $row["image_path"];
                $marque = $row["marque"];
                $modele = $row["modele"];
                $annee = $row["annee"];
                $description = $row["description"];
                $prix_par_jour = $row["prix_par_jour"];
                $nombre_de_places = $row["nombre_de_places"];
                $type_de_carburant = $row["type_de_carburant"];
                $transmission = $row["transmission"];
            } else {
                header("location: error.php");
                exit;
            }
        } else {
            echo "Erreur lors de l'exécution de la requête.";
        }
        unset($stmt);
    } else {
        header("location: error.php");
        exit;
    }
    ?>

    <div class="container">
        <h1>Détails de la Voiture</h1>


        <div class="voiture-card">
            <div class="details">
                <label><i class="fas fa-car"></i> Marque:</label>
                <p><?php echo htmlspecialchars($marque); ?></p>
            </div>
            <div class="details">
                <label><i class="fas fa-car"></i> Modèle:</label>
                <p><?php echo htmlspecialchars($modele); ?></p>
            </div>
            <div class="details">
                <label><i class="fas fa-calendar-alt"></i> Année:</label>
                <p><?php echo htmlspecialchars($annee); ?></p>
            </div>
            <div class="details">
                <label><i class="fas fa-money-bill-wave"></i> Prix par jour:</label>
                <p><?php echo htmlspecialchars($prix_par_jour); ?>€</p>
            </div>
            <div class="details">
                <label><i class="fas fa-info-circle"></i> Description:</label>
                <p><?php echo htmlspecialchars($description); ?></p>
            </div>
            <div class="details">
                <label><i class="fas fa-users"></i> Nombre de places :</label>
                <p><?= htmlspecialchars($nombre_de_places); ?></p>
            </div>
            <div class="details">
                <label><i class="fas fa-gas-pump"></i> Type de carburant :</label>
                <p><?= htmlspecialchars($type_de_carburant); ?></p>
            </div>
            <div class="details">
                <label><i class="fas fa-cogs"></i> Transmission :</label>
                <p><?= htmlspecialchars($transmission); ?></p>
            </div>
            <div class="details">
                <img src="<?= htmlspecialchars($imagePath) ?>" alt="Image de la voiture" style="max-width:100%;">
            </div>
            <button class="bouton-detail">Détail</button>
            <div class="informations-cachees" style="display: none;">

                <p>Age minimum : 21 ans</p>
                <p> Nombre minimum d'années de permis : 2 ans</p>
                <p> Votre loueur vous prend en charge personnellement dès le passage de la douane et vous emmène à leur agence située à 10 minutes de l'aéroport. Ceci vous évitera d'attendre au comptoir de l'aéroport après de nombreuses heures de vols et de payer la taxe d'aéroport.</p>

            </div>
        </div>


    </div>

    <h2 class="text1">Commander cette voiture</h2>
    <form action="traitement_commande.php" method="post" id="commandeForm">
        <table>
            <tr style="display: none;">
                <td><input type="hidden" name="voiture_id" value="<?php echo $row['id_voiture']; ?>"></td>
                <td><input type="hidden" name="marque" value="<?php echo htmlspecialchars($marque); ?>"></td>
                <td><input type="hidden" name="modele" value="<?php echo htmlspecialchars($modele); ?>"></td>
                <td><input type="hidden" name="annee" value="<?php echo htmlspecialchars($annee); ?>"></td>
                <td><input type="hidden" name="prix_par_jour" value="<?php echo htmlspecialchars($prix_par_jour); ?>"></td>
            </tr>

            <tr>
                <td><label for="nom_utilisateur">Nom de l'utilisateur :</label></td>
                <td><input type="text" id="nom_utilisateur" name="nom_utilisateur" required></td>
            </tr>
            <tr>
                <td><label for="email_utilisateur">Adresse e-mail :</label></td>
                <td><input type="email" id="email_utilisateur" name="email_utilisateur" required></td>
            </tr>
            <tr>
                <td><label for="date_debut">Date de début :</label></td>
                <td><input type="date" id="date_debut" name="date_debut" required></td>
            </tr>
            <tr>
                <td><label for="date_fin">Date de fin :</label></td>
                <td><input type="date" id="date_fin" name="date_fin" required></td>
            </tr>
            <tr>
                <td><label for="location_id">Choisir une location :</label></td>
                <td>
                    <select id="location_id" name="location_id">
                        <?php

                        $locations = [
                            ["id" => 1, "nom" => "Aréoport Saint Denis"],
                            ["id" => 2, "nom" => "Aréoport Saint Pierre"],
                        ];

                        foreach ($locations as $location) {
                            echo "<option value='" . $location['id'] . "'>" . htmlspecialchars($location['nom']) . "</option>";
                        }
                        ?>
                    </select>

            <tr>
                <td><label for="siege_bebe">Siège bébé (5€/siège) :</label></td>
                <td>
                    <input type="checkbox" id="siege_bebe" name="siege_bebe">
                    <input type="number" id="nombre_sieges_bebe" name="nombre_sieges_bebe" min="0" style="width: 50px;" value="0">
                </td>
            </tr>
            <tr>
                <td><label for="gps">GPS (15€) :</label></td>
                <td><input type="checkbox" id="gps" name="gps"></td>
            </tr>

            </td>
            </tr>
            <tr>
                <td><label for="prix_total">Prix total :</label></td>
                <td><input type="text" id="prix_total" name="prix_total" readonly></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Commander"></td>
            </tr>
        </table>
        <p class="text3">
            <i class="fas fa-atom"></i> Vous devez récupérer votre voiture dans un des lieux de l'aéroport
        </p>
    </form>

    <script>
        document.querySelectorAll(".bouton-detail").forEach(function(bouton) {
            bouton.addEventListener("click", function() {

                const informationsCachees = bouton.nextElementSibling;


                if (informationsCachees.style.display === "none") {
                    informationsCachees.style.display = "block";
                } else {
                    informationsCachees.style.display = "none";


                }
            });
        });


        function calculerPrixTotal() {
            const dateDebut = new Date(document.getElementById("date_debut").value);
            const dateFin = new Date(document.getElementById("date_fin").value);
            const prixParJour = parseFloat("<?php echo $prix_par_jour; ?>");
            const siegeBebe = document.getElementById("siege_bebe").checked;
            const nombreSiegesBebe = parseInt(document.getElementById("nombre_sieges_bebe").value) || 0;
            const gps = document.getElementById("gps").checked;
            const prixSiegeBebe = 5;
            const prixGps = 15;

            if (!isNaN(dateDebut) && !isNaN(dateFin) && prixParJour) {
                if (dateFin > dateDebut) {
                    const differenceJours = Math.ceil((dateFin - dateDebut) / (1000 * 60 * 60 * 24));
                    let prixTotal = prixParJour * differenceJours;

                    if (siegeBebe) {
                        prixTotal += nombreSiegesBebe * prixSiegeBebe;
                    }

                    if (gps) {
                        prixTotal += prixGps;
                    }

                    document.getElementById("prix_total").value = prixTotal.toFixed(2) + "€";
                } else {
                    alert("Veuillez entrer une date valide.");
                    document.getElementById("prix_total").value = "";
                }
            } else {
                document.getElementById("prix_total").value = "";
            }
        }

        document.getElementById("date_debut").addEventListener("change", calculerPrixTotal);
        document.getElementById("date_fin").addEventListener("change", calculerPrixTotal);
        document.getElementById("siege_bebe").addEventListener("change", calculerPrixTotal);
        document.getElementById("nombre_sieges_bebe").addEventListener("change", calculerPrixTotal);
        document.getElementById("gps").addEventListener("change", calculerPrixTotal);

        calculerPrixTotal();
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            
            $('#date_debut, #date_fin').on('change', function() {
               
                var dateDebut = $('#date_debut').val();
                var dateFin = $('#date_fin').val();
               
                var voitureId = $('input[name="voiture_id"]').val();

               
                if (dateDebut && dateFin) {
                    $.ajax({
                        url: 'verifier_disponibilite.php', 
                        type: 'POST',
                        dataType: 'text', 
                        data: {
                            voitureId: voitureId,
                            dateDebut: dateDebut,
                            dateFin: dateFin
                        },
                        success: function(response) {
                            // Traite la réponse du serveur
                            if (response.trim() === 'indisponible') {
                                // Si la voiture n'est pas disponible, affiche une alerte
                                alert("La voiture sélectionnée n'est pas disponible pour les dates choisies.");
                                
                                $('input[type="submit"]').prop('disabled', true);
                            } else {
                               
                                $('input[type="submit"]').prop('disabled', false);
                            }
                        },
                        error: function(xhr, status, error) {
                           
                            console.error("Erreur AJAX : " + status + " - " + error);
                        }
                    });
                }
            });
        });
    </script>


</body>

</html>