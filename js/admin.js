document.addEventListener("DOMContentLoaded", function() {
    
    function validateForm() {
        var marque = document.getElementById('marque').value;
        var modele = document.getElementById('modele').value;
        var annee = document.getElementById('annee').value;
        var prixParJour = document.getElementById('prix_par_jour').value;

        if (marque.trim() === '') {
            alert('Veuillez entrer la marque de la voiture.');
            return false;
        }

        if (modele.trim() === '') {
            alert('Veuillez entrer le modèle de la voiture.');
            return false;
        }

        if (annee.trim() === '' || isNaN(annee) || parseInt(annee) <= 1900 || parseInt(annee) > new Date().getFullYear()) {
            alert('Veuillez entrer une année valide.');
            return false;
        }

        if (prixParJour.trim() === '' || isNaN(prixParJour) || parseFloat(prixParJour) <= 0) {
            alert('Veuillez entrer un prix par jour valide.');
            return false;
        }

        
        return true;
    }

   
    var form = document.querySelector('form');
    form.onsubmit = function(event) {
        if (!validateForm()) {
            event.preventDefault();
        }
    };
});
