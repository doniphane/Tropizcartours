<?php

session_start();


if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once "auth_check.php";


if (!checkUserRole('admin')) {
    header("location: index.php");
    exit;
}

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Administration</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-gray-100">

    <div class="navbar bg-gray-800 text-white py-4">
        <a href="#utilisateurs" class="px-4"><i class="fas fa-users"></i> Utilisateurs</a>
        <a href="#locations" class="px-4"><i class="fas fa-car"></i> Locations</a>
        <a href="#messages" class="px-4"><i class="fas fa-envelope"></i> Messages</a>
        <a href="logout.php" class="px-4"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
    </div>

    <h2 class="text-2xl mt-4 mb-2 flex justify-center"><i class="fas fa-car "></i> Ajouter une nouvelle voiture</h2>

    <form action="ajouter_voiture.php" method="post" enctype="multipart/form-data" class="max-w-xl mx-auto bg-white p-8 shadow-md rounded-lg">
        <label class="block mb-2">Marque :</label>
        <input type="text" name="marque" required class="border border-gray-300 rounded-md px-3 py-2 mb-3 focus:outline-none focus:border-blue-500 w-full">

        <label class="block mb-2">Modèle :</label>
        <input type="text" name="modele" required class="border border-gray-300 rounded-md px-3 py-2 mb-3 focus:outline-none focus:border-blue-500 w-full">

        <label class="block mb-2">Année :</label>
        <input type="text" name="annee" required class="border border-gray-300 rounded-md px-3 py-2 mb-3 focus:outline-none focus:border-blue-500 w-full">

        <label class="block mb-2">Prix par jour :</label>
        <input type="text" name="prix_par_jour" required class="border border-gray-300 rounded-md px-3 py-2 mb-3 focus:outline-none focus:border-blue-500 w-full">

        <label class="block mb-2">Image :</label>
        <input type="file" name="image" required class="border border-gray-300 rounded-md px-3 py-2 mb-3 focus:outline-none focus:border-blue-500 w-full">

        <label class="block mb-2">Description :</label>
        <textarea name="description" required class="border border-gray-300 rounded-md px-3 py-2 mb-3 focus:outline-none focus:border-blue-500 w-full"></textarea>

        <label class="block mb-2">Nombre de places :</label>
        <input type="text" name="nombre_de_places" required class="border border-gray-300 rounded-md px-3 py-2 mb-3 focus:outline-none focus:border-blue-500 w-full">

        <label class="block mb-2">Type de carburant :</label>
        <input type="text" name="type_de_carburant" required class="border border-gray-300 rounded-md px-3 py-2 mb-3 focus:outline-none focus:border-blue-500 w-full">

        <label class="block mb-2">Transmission :</label>
        <input type="text" name="transmission" required class="border border-gray-300 rounded-md px-3 py-2 mb-3 focus:outline-none focus:border-blue-500 w-full">

        <input type="submit" name="submit" value="Ajouter la voiture" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 cursor-pointer w-full">
    </form>

    <h2 class="text-2xl mt-8 flex justify-center">Liste des Voitures</h2>

    <?php
    require_once "db.php";
    try {
        $sql = "SELECT * FROM voitures";
        $result = $pdo->query($sql);

        if ($result->rowCount() > 0) {
            echo '<div class="flex justify-center">';
            echo '<div class="w-full lg:w-2/3">';
            echo "<table class='mt-4'>";
            echo "<tr>";
            echo "<th class='px-4 py-2'><i class='fas fa-tag'></i> Marque</th>";
            echo "<th class='px-4 py-2'><i class='fas fa-cube'></i> Modèle</th>";
            echo "<th class='px-4 py-2'><i class='fas fa-calendar'></i> Année</th>";
            echo "<th class='px-4 py-2'><i class='fas fa-money-bill-wave'></i> Prix/Jour</th>";
            echo "<th class='px-4 py-2'><i class='fas fa-cogs'></i> Actions</th>";
            echo "</tr>";

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['marque']) . "</td>";
                echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['modele']) . "</td>";
                echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['annee']) . "</td>";
                echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['prix_par_jour']) . "</td>";
                echo "<td class='border px-4 py-2'>";
                echo "<a href='editer_voiture.php?id=" . $row['id_voiture'] . "' class='text-blue-600'><i class='fas fa-edit'></i> Éditer</a> | ";
                echo "<a href='supprimer_voiture.php?id=" . $row['id_voiture'] . "' class='text-red-600'><i class='fas fa-trash'></i> Supprimer</a> | ";
                echo "<a href='desactiver_voiture.php?id=" . $row['id_voiture'] . "' class='text-yellow-600'><i class='fas fa-ban'></i> Désactiver</a>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>"; // Fermeture de la div pour la largeur de la table
            echo "</div>"; // Fermeture de la div pour le centrage
        } else {
            echo "<p class='mt-4'>Aucune voiture disponible.</p>";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
    ?>



    <?php
    try {
        $sqlUtilisateurs = "SELECT * FROM utilisateurs";
        $resultUtilisateurs = $pdo->query($sqlUtilisateurs);

        if ($resultUtilisateurs->rowCount() > 0) {
            echo '<div class="flex justify-center">';
            echo '<div class="w-full lg:w-2/3">';
            echo '<h2 id="utilisateurs" class="text-2xl mt-8">Liste des utilisateurs</h2>';
            echo "<table class='mt-4 w-full'>";
            echo "<tr>";
            echo "<th class='px-4 py-2'><i class='fas fa-id-card'></i> ID</th>";
            echo "<th class='px-4 py-2'><i class='fas fa-user'></i> Nom</th>";
            echo "<th class='px-4 py-2'><i class='fas fa-envelope'></i> Email</th>";
            echo "<th class='px-4 py-2'><i class='fas fa-calendar'></i> Date d'inscription</th>";
            echo "<th class='px-4 py-2'><i class='fas fa-user-shield'></i> Role</th>";
            echo "<th class='px-4 py-2'><i class='fas fa-cogs'></i> Actions</th>";
            echo "</tr>";

            while ($row = $resultUtilisateurs->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['id_utilisateur']) . "</td>";
                echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['nom']) . "</td>";
                echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['date_inscription']) . "</td>";
                echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['role']) . "</td>";
                echo "<td class='border px-4 py-2'>";
                echo "<a href='modifier_utilisateur.php?id=" . $row['id_utilisateur'] . "' class='text-blue-600'><i class='fas fa-edit'></i> Modifier</a> | ";
                echo "<a href='supprimer_utilisateur.php?id=" . $row['id_utilisateur'] . "' class='text-red-600'><i class='fas fa-trash'></i> Supprimer</a>";

                echo "</td>";
                echo "</tr>";
            }

            echo "</table>";
            echo "</div>";
            echo "</div>";
        } else {
            echo "<p class='mt-4'>Aucun utilisateur trouvé.</p>";
        }
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }

    ?>



    <?php
    try {
        $sqlLocations = "SELECT * FROM locations";
        $resultLocations = $pdo->query($sqlLocations);

        if ($resultLocations->rowCount() > 0) {
            echo '<div class="flex justify-center">';
            echo '<div>';
            echo '<h2 id="locations" class="text-2xl mt-8 flex justify-center">Liste des locations</h2>';
            echo "<form method='post' action='modifier_etat_commande.php'>";
            echo "<table class='mt-4'>";
            echo "<tr>";
            echo "<th class='px-4 py-2 bg-blue-500 text-white'><i class='fas fa-id-card'></i> ID Location</th>";
            echo "<th class='px-4 py-2 bg-blue-500 text-white'><i class='fas fa-user'></i> ID Utilisateur</th>";
            echo "<th class='px-4 py-2 bg-blue-500 text-white'><i class='fas fa-car'></i> ID Voiture</th>";
            echo "<th class='px-4 py-2 bg-blue-500 text-white'><i class='fas fa-calendar'></i> Date Debut</th>";
            echo "<th class='px-4 py-2 bg-blue-500 text-white'><i class='fas fa-calendar'></i> Date Fin</th>";
            echo "<th class='px-4 py-2 bg-blue-500 text-white'><i class='fas fa-money-bill-wave'></i> Prix Total</th>";
            echo "<th class='px-4 py-2 bg-blue-500 text-white'><i class='fas fa-envelope'></i> Email Utilisateur</th>";
            echo "<th class='px-4 py-2 bg-blue-500 text-white'><i class='fas fa-user'></i> Nom Utilisateur</th>";
            echo "<th class='px-4 py-2 bg-blue-500 text-white'><i class='fas fa-user'></i> État Commande</th>";
            echo "<th class='px-4 py-2 bg-blue-500 text-white'>Action</th>";
            echo "</tr>";

            while ($row = $resultLocations->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['id_location']) . "</td>";
                echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['id_utilisateur']) . "</td>";
                echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['id_voiture']) . "</td>";
                echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['date_debut']) . "</td>";
                echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['date_fin']) . "</td>";
                echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['prix_total']) . "</td>";
                echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['email_utilisateur']) . "</td>";
                echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['nom_utilisateur']) . "</td>";
                echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['etat_commande']) . "</td>";
                echo "<td class='border px-4 py-2'><a href='page_selection_etat.php?id_location=" . htmlspecialchars($row['id_location']) . "' class='bg-blue-500 text-white px-2 py-1 rounded-md'>Modifier l'état</a></td>";

                echo "</tr>";
            }
            echo "</table>";
            echo "</form>";
            echo "</div>";
            echo "</div>";
        } else {
            echo "<p class='mt-4'>Aucune location trouvée.</p>";
        }
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
    ?>




    <<?php
        try {
            $sqlMessages = "SELECT * FROM messages";
            $resultMessages = $pdo->query($sqlMessages);

            if ($resultMessages->rowCount() > 0) {
                echo '<div class="flex justify-center">';
                echo '<div>';
                echo '<h2 id="messages" class="text-2xl mt-8">Liste des messages</h2>';
                echo "<table class='mt-4'>";
                echo "<tr>";
                echo "<th class='px-4 py-2 bg-blue-500 text-white'><i class='fas fa-id-card'></i> ID</th>";
                echo "<th class='px-4 py-2 bg-blue-500 text-white'><i class='fas fa-user'></i> Nom</th>";
                echo "<th class='px-4 py-2 bg-blue-500 text-white'><i class='fas fa-envelope'></i> Email</th>";
                echo "<th class='px-4 py-2 bg-blue-500 text-white'><i class='fas fa-comment'></i> Message</th>";
                echo "<th class='px-4 py-2 bg-blue-500 text-white'><i class='fas fa-calendar'></i> Date d'envoi</th>";
                echo "</tr>";

                while ($row = $resultMessages->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td class='border px-4 py-2 bg-gray-100'>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td class='border px-4 py-2 bg-gray-100'>" . htmlspecialchars($row['nom']) . "</td>";
                    echo "<td class='border px-4 py-2 bg-gray-100'>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td class='border px-4 py-2 bg-gray-100'>" . htmlspecialchars($row['message']) . "</td>";
                    echo "<td class='border px-4 py-2 bg-gray-100'>" . htmlspecialchars($row['date_envoi']) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "</div>"; // Fermeture de la div pour centrer la table
                echo "</div>"; // Fermeture de la div pour le centrage
            } else {
                echo "<p class='mt-4'>Aucun message trouvé.</p>";
            }
        } catch (PDOException $e) {
            die("Erreur : " . $e->getMessage());
        }
        ?> </body>

</html>