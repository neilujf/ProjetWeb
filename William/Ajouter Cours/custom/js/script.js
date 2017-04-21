//Vérification des champs du formulaire
function verifForm(){
			if((document.getElementById("date_debut").value != "") && (document.getElementById("date_fin").value != "") && (document.getElementById("lieu").value != "") && (document.getElementById("capacite").value >= 0) && (document.getElementById("formation").value != "")) {
                $("#formAdd form")[0].elements.add_button_send.disabled = false;
                $("#formEdit form")[0].elements.edit_button_send.disabled = false;
            }
            else {
                $("#formAdd form")[0].elements.add_button_send.disabled = true;
                $("#formEdit form")[0].elements.edit_button_send.disabled = true;
            }
}


// Calendriers en français
$(function() {
    $('#datetimepicker1').datetimepicker({
        language: 'fr'
    });
});
$(function() {
    $('#datetimepicker2').datetimepicker({
        language: 'fr'
    });
});


// Fonction affichage du contenu du tableau
function showTable(){
	$("#container-table").empty();
	$.ajax({
		method: "POST",
		url: "custom/php/ajax.php",
		data: { requete: "recuperer" }
	})
	.done(function(retour){
		$("#container-table").append(retour);
		
		// Initialisation du plugin de tri du tableau
		$('#cours').dataTable({
			"columnDefs": [{
				"targets": [6],
				"searchable": false,
				"orderable": false,
				"visible": true
			}],
			"aLengthMenu": [
			[10, 25 ,50, 100, -1],
			[10, 25 ,50, 100, "Tout"]
			],
			"language": {
				"sProcessing":     "Traitement en cours...",
				"sSearch":         "Rechercher&nbsp;:",
				"sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
				"sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
				"sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
				"sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
				"sInfoPostFix":    "",
				"sLoadingRecords": "Chargement en cours...",
				"sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
				"sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
				"oPaginate": {
					"sFirst":      "Premier",
					"sPrevious":   "Pr&eacute;c&eacute;dent",
					"sNext":       "Suivant",
					"sLast":       "Dernier"
				},
				"oAria": {
					"sSortAscending":  ": activer pour trier la colonne par ordre croissant",
					"sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
				}
			}

		} );
});	
}

// Quand le document est chargé
$(document).ready(function(){

	// Cacher formulaires
	$("#formAdd").hide();
	$("#formEdit").hide();
	$(".hide-on").hide();

	// Affichage du contenu du tableau
	showTable();

	// Clic sur le lien ajout
	$("button#showFormAdd").click(function(event){
        $("#formAdd form")[0].elements.add_button_send.disabled = true;
		$("#formAdd").fadeToggle("slow");
	});

	// #formAdd Clic sur le bouton envoyer
	$("#formAdd #button_send").click(function(){
		$("#formAdd").fadeOut("slow",function(){
			var form_val = $("#formAdd form").serialize();

			$.ajax({
				method: "POST",
				url: "custom/php/ajax.php",
				data: {requete: "ajouter", form_val: form_val}
			})
				.done(function (retour) {
					showTable();
					$("formAdd").find("input[type=text], textarea").val("");
				});
		});
	});

	// #formAdd Click sur le bouton annuler
	$("#formAdd #button_cancel").click(function(){
		$("#formAdd").fadeOut("slow");
	});




	// #formEdit Click sur le bouton envoyer
	$("#formEdit #button_send").click(function(){
		$("#formEdit").fadeOut("slow",function(){

			var form_val = $("#formEdit form").serialize();

			$.ajax({
				method: "POST",
				url: "custom/php/ajax.php",
				data: { requete: "edit", form_val: form_val }
			})
			.done(function(retour) {
				showTable();
				$("formEdit").find("input[type=date], textarea").val("");
			});
		});
	});

	// #formEdit Click sur le bouton annuler
	$("#formEdit #button_cancel").click(function(){
		$("#formEdit").fadeOut("slow");
	});

});	

// BOUTON D'ACTIONS

function actions(action,id){

	// Bouton supprimer
	if(action == "delete"){
		if(confirm('Voulez-vous vraiment supprimer cet élément de façon définitive ?')){
			$.ajax({
				method: "POST",
				url: "custom/php/ajax.php",
				data: { requete: "delete", id: id }
			})
			.done(function() {
				showTable();
			});
		}
	}

	// Bouton modifier
	if(action == "edit"){
		$("#formEdit form")[0].elements.edit_button_send.disabled = true;

		$.ajax({
			method: "POST",
			url: "custom/php/ajax.php",
			data: { requete: "recuperer-id", id:id }
		})
		.done(function(retour) {
			var cours = jQuery.parseJSON(retour);

			$("html, body").animate({ scrollTop: 0 }, "slow");

			$("#formEdit").fadeOut("slow");

			$("#formEdit h1 b").text(cours.id);
			$("#formEdit input[name*='id']").val(cours.id);
			$("#formEdit input[name*='date_debut']").val(cours.date_debut);
			$("#formEdit input[name*='date_fin']").val(cours.date_fin);
			$("#formEdit input[name*='lieu']").val(cours.lieu);
			$("#formEdit input[name*='capacite']").val(cours.capacite);
			$("#formEdit select[name*='formation']").val(cours.id_formation);

			$("#formEdit").fadeIn("slow");
		});
	}
}