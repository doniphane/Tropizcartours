<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Message Envoyé</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding-top: 50px;
        }

        .message-success {
            width: 80%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #d4d4d4;
            background-color: #e9ffe9;
            color: #4F8A10;
        }

        a {
            color: #0056b3;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="message-success">
        <h1>Votre message a été envoyé avec succès!</h1>
        <p>Merci de nous avoir contacté. Nous vous répondrons dès que possible.</p>
        <p><a href="index.php">Retour à la page d'accueil</a></p>
        <p>Redirection automatique dans <span id="timer">5</span> secondes...</p>
    </div>

    <script>
        var timeLeft = 5; 
        var timerElement = document.getElementById('timer');
        var timerId = setInterval(countdown, 1000);

        function countdown() {
            if (timeLeft == 0) {
                clearTimeout(timerId);
                window.location.href = 'index.php'; 
            } else {
                timerElement.innerHTML = timeLeft;
                timeLeft--;
            }
        }
    </script>
</body>

</html>