<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

$(document).ready(function() {
   
    $('#date_debut, #date_fin').on('change', function() {
   
        var dateDebut = $('#date_debut').val();
        var dateFin = $('#date_fin').val();
    
        var voitureId = $('input[name="voiture_id"]').val();

        if (dateDebut && dateFin) {
            $.ajax({
                url: 'verifier_disponibilite.php', 
                type: 'POST',
                dataType: 'text', 
                data: {
                    voitureId: voitureId,
                    dateDebut: dateDebut,
                    dateFin: dateFin
                },
                success: function(response) {
                    
                    if (response.trim() === 'indisponible') {
                       
                        alert("La voiture sélectionnée n'est pas disponible pour les dates choisies.");
              
                        $('input[type="submit"]').prop('disabled', true);
                    } else {
                   
                        $('input[type="submit"]').prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                   
                    console.error("Erreur AJAX : " + status + " - " + error);
                }
            });
        }
    });
});

