// Call the dataTables jQuery plugin
$(document).ready(function() {

  $('#dataTable').DataTable( {
    language: {
      processing:     "Traitement en cours...",
      search:         "Rechercher :",
      lengthMenu:    "Afficher _MENU_ éléments",
      info:           "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
      infoEmpty:      "Affichage de l'élément 0 à 0 sur 0 élément",
      infoFiltered:   "(filtré à partir de _MAX_ éléments au total)",
      infoPostFix:    "",
      infoThousands:  ",",
      loadingRecords: "Chargement en cours...",
      zeroRecords:    "Aucun élément correspondant trouvé",
      emptyTable:     "Aucune donnée disponible dans le tableau",
      paginate: {
        first:      "Premier",
        previous:   "Précédent",
        next:       "Suivant",
        last:       "Dernier"
      },
      aria: {
        sortAscending:  ": activer pour trier la colonne par ordre croissant",
        sortDescending: ": activer pour trier la colonne par ordre décroissant"
      }
    }
  } );
});
