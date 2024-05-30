<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/NavBar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>NavBar</title>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="nav-logo">
                <img src="./img/logo2.png" alt="Logo" style="height: 100px;" />
            </a>

            <ul class="nav-menu" id="navMenu">
                <li class="nav-item">
                    <a href="index.php" class="nav-links"><i class="fas fa-home"></i> Accueil</a>
                </li>
                <li class="nav-item">
                    <a href="catalogue.php" class="nav-links"><i class="fas fa-car"></i> Catalogue</a>
                </li>
                <li class="nav-item">
                    <a href="commandes.php" class="nav-links"><i class="fas fa-shopping-cart"></i> Voir mes commandes</a>
                </li>
                <li class="nav-item">
                    <a href="contact.php" class="nav-links"><i class="fas fa-envelope"></i> Contact</a>
                </li>
                <li class="nav-item">
                    <a href="faq.php" class="nav-links"><i class="fas fa-question-circle"></i> FAQ</a>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-links"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
                </li>
            </ul>

            <div class="nav-icon" id="navIcon">
                <i class="fa-solid fa-bars"></i>
            </div>
        </div>
    </nav>
    <script defer src="js/navbar.js"></script>
</body>
</html>
