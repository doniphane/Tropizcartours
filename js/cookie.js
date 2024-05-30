document.addEventListener('DOMContentLoaded', function() {
    const cookieBanner = document.getElementById('cookie-banner');
    const acceptCookiesBtn = document.getElementById('accept-cookies');

    // Vérifiez si le consentement aux cookies a déjà été donné
    const cookiesAccepted = localStorage.getItem('cookiesAccepted');

    if (!cookiesAccepted) {
        cookieBanner.classList.add('show'); // Affichez la bannière si le consentement n'a pas été donné
    }

    // Ajoutez un gestionnaire d'événements au bouton d'acceptation
    acceptCookiesBtn.addEventListener('click', function() {
        localStorage.setItem('cookiesAccepted', true); // Enregistrez le consentement dans le stockage local
        cookieBanner.classList.remove('show'); // Cachez la bannière après avoir accepté les cookies
    });
});
