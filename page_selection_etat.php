<?php
$id_location = $_GET['id_location'] ?? ''; 
?>
<!DOCTYPE html>
<html lang="fr">
    <link rel="stylesheet" href="./css/page_selection.css">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>page page_selection_etat</title>
</head>

<body>
    <h2>Modifier l'état de la location</h2>
    <form action="traitement_changement_etat.php" method="post">
        <input type="hidden" name="id_location" value="<?php echo htmlspecialchars($id_location); ?>">
        <label for="nouvel_etat">Nouvel État :</label>
        <select name="nouvel_etat" id="nouvel_etat">
            <option value="En attente">En attente</option>
            <option value="Livrée">Livrée</option>
           
        </select>
        <button type="submit">Mettre à jour l'état</button>
    </form>
</body>

</html>