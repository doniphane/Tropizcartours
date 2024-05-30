<?php
require_once "db.php"; 
session_start(); // Démarrer la session

// Vérifier si l'utilisateur est déjà connecté et le rediriger vers la page d'accueil
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

// Initialiser les variables pour stocker les données du formulaire et les messages d'erreur
$nom = $email = $password = $confirm_password = "";
$nom_err = $email_err = $password_err = $confirm_password_err = "";

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Assainir les entrées du formulaire pour prévenir les attaques XSS
    $nom = htmlspecialchars(trim($_POST["nom"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = htmlspecialchars(trim($_POST["password"]));
    $confirm_password = htmlspecialchars(trim($_POST["confirm_password"]));

    // Valider le nom
    if (empty($nom)) {
        $nom_err = "Veuillez entrer un nom."; 
    }

    // Valider l'email
    if (empty($email)) {
        $email_err = "Veuillez entrer un email."; 
    } else {
        // Préparer la requête SQL pour vérifier si l'email existe déjà
        $sql = "SELECT id_utilisateur FROM utilisateurs WHERE email = :email";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            // Exécuter la requête et vérifier si l'email existe déjà
            if ($stmt->execute() && $stmt->rowCount() == 1) {
                $email_err = "Cet email est déjà utilisé."; 
            }
        } else {
            echo "Oops! Quelque chose s'est mal passé. Veuillez réessayer plus tard."; 
        }
        unset($stmt); // Fermer la requête préparée
    }

    // Valider le mot de passe
    if (empty($password)) {
        $password_err = "Veuillez entrer un mot de passe."; 
    } elseif (strlen($password) < 6) {
        $password_err = "Le mot de passe doit avoir au moins 6 caractères."; 
    }

    // Valider la confirmation du mot de passe
    if (empty($confirm_password)) {
        $confirm_password_err = "Veuillez confirmer le mot de passe."; 
    } elseif ($password != $confirm_password) {
        $confirm_password_err = "Les mots de passe ne correspondent pas."; 
    }

    // Insérer dans la base de données si aucune erreur
    if (empty($nom_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        // Préparer la requête SQL pour insérer les données de l'utilisateur
        $sql = "INSERT INTO utilisateurs (nom, email, mot_de_passe, role) VALUES (:nom, :email, :mot_de_passe, 'user')";
        if ($stmt = $pdo->prepare($sql)) {
            $param_password = password_hash($password, PASSWORD_BCRYPT); 
            // Lier les paramètres à la requête
            $stmt->bindParam(":nom", $nom, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":mot_de_passe", $param_password, PDO::PARAM_STR);

            // Exécuter la requête et rediriger vers la page de connexion si réussi
            if ($stmt->execute()) {
                header("location: login.php");
                exit;
            } else {
                echo "Quelque chose s'est mal passé. Veuillez réessayer plus tard."; 
            }
            unset($stmt); // Fermer la requête préparée
        }
    }
    unset($pdo); // Fermer la connexion à la base de données
}
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="css/register.css">
    <script src="./js/register.js"></script> 
</head>

<body>
    <div>
        <h2>Inscription</h2>
        <p>Veuillez remplir ce formulaire pour créer un compte.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <label>Nom</label>
                <input type="text" name="nom" value="<?php echo $nom; ?>">
                <span><?php echo $nom_err; ?></span>
            </div>
            <div>
                <label>Email</label>
                <input type="text" name="email" value="<?php echo $email; ?>">
                <span><?php echo $email_err; ?></span>
            </div>
            <div>
                <label>Mot de passe</label>
                <input type="password" name="password" value="<?php echo htmlspecialchars($password); ?>" onkeyup="checkPasswordStrength();">
                <span><?php echo $password_err; ?></span>
                <progress id="strengthBar" value="0" max="4"></progress> 
            </div>
            <div>
                <label>Confirmer le mot de passe</label>
                <input type="password" name="confirm_password" value="<?php echo $confirm_password; ?>">
                <span><?php echo $confirm_password_err; ?></span>
            </div>
            <div>
                <input type="submit" value="Inscription">
            </div>
            <p>Vous avez déjà un compte? <a href="login.php">Connectez-vous ici</a>.</p>
        </form>
    </div>
</body>

</html>