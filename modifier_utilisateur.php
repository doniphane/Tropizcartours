<?php

session_start();

require_once "auth_check.php";
require_once "db.php";


if (!checkUserRole('admin')) {
    header("location: index.php");
    exit;
}


if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = trim($_GET["id"]);


    $sql = "SELECT * FROM utilisateurs WHERE id_utilisateur = :id";
    if ($stmt = $pdo->prepare($sql)) {
       
        $stmt->bindParam(":id", $param_id);

       
        $param_id = $id;

        
        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
               
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                
                $nom = $row["nom"];
                $email = $row["email"];
               
            } else {
                
                header("location: error.php");
                exit();
            }
        } else {
            echo "Oops! Quelque chose s'est mal passé. Veuillez réessayer plus tard.";
        }
    }

  
    unset($stmt);
} else {
    
    header("location: error.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $id = $_POST["id"];

    
    $nom = trim($_POST["nom"]);
    $email = trim($_POST["email"]);
    

 
    $sql = "UPDATE utilisateurs SET nom = :nom, email = :email WHERE id_utilisateur = :id";

    if ($stmt = $pdo->prepare($sql)) {
       
        $stmt->bindParam(":nom", $param_nom);
        $stmt->bindParam(":email", $param_email);
        $stmt->bindParam(":id", $param_id);

        
        $param_nom = $nom;
        $param_email = $email;
        $param_id = $id;

       
        if ($stmt->execute()) {
           
            header("location: admin_dashboard.php");
            exit();
        } else {
            echo "Erreur lors de la mise à jour des données.";
        }
    }

  
    unset($stmt);
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier Utilisateur</title>
    
</head>

<body>
    <a href="admin_dashboard.php">Retour au tableau de bord</a>
    <h2>Modifier Utilisateur</h2>

    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
        <label>Nom:</label>
        <input type="text" name="nom" value="<?php echo $nom; ?>"><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $email; ?>"><br>

       

        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="submit" value="Mettre à jour">
        <a href="admin_dashboard.php">Annuler</a>
    </form>
</body>

</html>