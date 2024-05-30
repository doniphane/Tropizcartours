<?php
session_start();
require_once "db.php";
require_once "auth_check.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !checkUserRole('user')) {
    header("location: login.php");
    exit;
}

$email = $nom = $message = "";
$email_err = $nom_err = $message_err = $success_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    if (empty(trim($_POST["nom"]))) {
        $nom_err = "Veuillez entrer un nom.";
    } else {
        $nom = htmlspecialchars(trim($_POST["nom"]));
    }

    if (empty(trim($_POST["email"]))) {
        $email_err = "Veuillez entrer un email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "L'email entré n'est pas valide.";
    } else {
        $email = htmlspecialchars(trim($_POST["email"]));
    }


    if (empty(trim($_POST["message"]))) {
        $message_err = "Veuillez entrer un message.";
    } else {
        $message = htmlspecialchars(trim($_POST["message"]));
    }


    if (empty($nom_err) && empty($email_err) && empty($message_err)) {
        $stmt = $pdo->prepare("INSERT INTO messages (nom, email, message) VALUES (?, ?, ?)");
        if ($stmt->execute([$nom, $email, $message])) {
            $success_msg = "Votre message a été envoyé avec succès.";
            header("Location: page_de_succes.php");
            exit;
        } else {
            echo "Oops! Quelque chose s'est mal passé. Veuillez réessayer plus tard .";
        }
    }
}

include('navbar.php');
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Contactez-Nous</title>
    <link rel="stylesheet" href="css/contact.css">
</head>

<body>
    <div class="contact-form">
        <h2>Contactez-Nous</h2>
        <?php
        if (!empty($success_msg)) {
            echo '<div class="alert alert-success">' . $success_msg . '</div>';
        }
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div>
                <label for="nom">Nom :</label><br>
                <input type="text" id="nom" name="nom" value="<?php echo $nom; ?>" required>
                <span><?php echo $nom_err; ?></span>
            </div>
            <div>
                <label for="email">Email :</label><br>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                <span><?php echo $email_err; ?></span>
            </div>
            <div>
                <label for="message">Message :</label><br>
                <textarea id="message" name="message" required><?php echo $message; ?></textarea>
                <span><?php echo $message_err; ?></span>
            </div>
            <div>
                <input type="submit" value="Envoyer">
            </div>
        </form>
    </div>
</body>

</html>