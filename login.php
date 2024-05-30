<?php
session_start(); // Démarrage de la session PHP

require_once "db.php"; // Inclusion du fichier de connexion à la base de données



// Initialisation des variables pour stocker les entrées de formulaire et les messages d'erreur
$email = $password = "";
$email_err = $password_err = "";

// Traitement du formulaire après soumission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validation et assainissement de l'email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Veuillez entrer un email."; // Message d'erreur si l'email est vide
    } else {
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL); // Assainissement de l'email
    }

    // Validation du mot de passe
    if (empty(trim($_POST["password"]))) {
        $password_err = "Veuillez entrer votre mot de passe."; // Message d'erreur si le mot de passe est vide
    } else {
        $password = trim($_POST["password"]); // Stockage du mot de passe
    }

    // Continuer si aucune erreur n'a été trouvée dans les entrées
    if (empty($email_err) && empty($password_err)) {

        // Préparation de la requête SQL pour vérifier l'email dans la base de données
        $sql = "SELECT id_utilisateur, email, mot_de_passe, nom, role FROM utilisateurs WHERE email = :email";

        if ($stmt = $pdo->prepare($sql)) {

            // Liaison du paramètre d'email
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

            // Définition du paramètre d'email
            $param_email = $email;

            // Exécution de la requête préparée
            if ($stmt->execute()) {

                // Vérification si un utilisateur correspondant a été trouvé
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $id_utilisateur = $row["id_utilisateur"];
                        $hashed_password = $row["mot_de_passe"];
                        $nom = $row["nom"];
                        $role = $row["role"];

                        // Vérification du mot de passe
                        if (password_verify($password, $hashed_password)) {

                            // Définition des cookies pour le nom et l'ID de l'utilisateur
                            setcookie("nom", $nom, time() + 86400 * 30, "/"); // expire dans 30 jours
                            setcookie("id_utilisateur", $id_utilisateur, time() + 86400 * 30, "/"); // expire dans 30 jours

                            // Regénération de l'ID de session pour la sécurité de la session
                            session_regenerate_id();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id_utilisateur"] = $id_utilisateur;
                            $_SESSION["nom"] = htmlspecialchars($nom); // Utilisation de htmlspecialchars pour prévenir les attaques XSS
                            $_SESSION["role"] = $role;

                            // Redirection en fonction du rôle de l'utilisateur
                            if ($role === "user") {
                                header("location: index.php");
                                exit;
                            } elseif ($role === "admin") {
                                header("location: admin_dashboard.php");
                                exit;
                            }
                        } else {
                            $password_err = "Email ou mot de passe incorrect."; // Utilisation d'un message d'erreur générique
                        }
                    }
                } else {
                    $email_err = "Email ou mot de passe incorrect."; // Utilisation d'un message d'erreur générique
                }
            } else {
                echo "Oops! Quelque chose s'est mal passé. Veuillez réessayer plus tard.";
            }

            // Fermeture de la requête préparée
            unset($stmt);
        }
    }

    // Fermeture de la connexion à la base de données
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
<div id="cookie-banner" class="fixed bottom-0 left-0 w-full bg-gray-800 text-white p-4 text-center">
    <p>Ce site utilise des cookies pour vous offrir la meilleure expérience utilisateur possible. En continuant à utiliser ce site, vous acceptez notre utilisation des cookies.</p>
    <button id="accept-cookies" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Accepter</button>
</div>

    <div>
        <h2>Connexion</h2>
        <p>Veuillez remplir ce formulaire pour vous connecter.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <label>Email</label>
                <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <span><?php echo $email_err; ?></span>
            </div>
            <div>
                <label>Mot de passe</label>
                <input type="password" name="password">
                <span><?php echo $password_err; ?></span>
            </div>
            <div>
                <input type="submit" value="Connexion">
            </div>
            <p>Vous n'avez pas de compte? <a href="register.php">Inscrivez-vous ici</a>.</p>
        </form>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const cookieBanner = document.getElementById('cookie-banner');
    const acceptCookiesBtn = document.getElementById('accept-cookies');

    // Vérifiez si le consentement aux cookies a déjà été donné
    const cookiesAccepted = localStorage.getItem('cookiesAccepted');

    if (!cookiesAccepted) {
        cookieBanner.classList.add('show'); 
    }

    // Ajoutez un gestionnaire d'événements au bouton d'acceptation
    acceptCookiesBtn.addEventListener('click', function() {
        localStorage.setItem('cookiesAccepted', true); 
        cookieBanner.classList.remove('show'); 
    });
});

</script>
</html>
