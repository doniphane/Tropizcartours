<?php

session_start();

require_once "auth_check.php";
require_once "db.php";


if (!checkUserRole('admin')) {
    header("location: index.php");
    exit;
}


if (isset($_POST["id"]) && !empty($_POST["id"])) {

    $sql = "DELETE FROM utilisateurs WHERE id_utilisateur = :id";

    if ($stmt = $pdo->prepare($sql)) {

        $stmt->bindParam(":id", $param_id);
        

        $param_id = trim($_POST["id"]);


        if ($stmt->execute()) {

            header("location: admin_dashboard.php");
            exit();
        } else {
            echo "Oops! Quelque chose s'est mal passé. Veuillez réessayer plus tard.";
        }
    }


    unset($stmt);
} else {

    if (empty(trim($_GET["id"]))) {

        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Supprimer Utilisateur</title>
    <link rel="stylesheet" href="./css/suprimer.css">
</head>

<body>
    <h2>Supprimer Utilisateur</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>" />
        <p>Êtes-vous sûr de vouloir supprimer cet utilisateur?</p><br>
        <input type="submit" value="Oui">
        <a href="admin_dashboard.php">Non</a>
    </form>
</body>

</html>