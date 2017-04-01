$( document ).ready(function() {

var page = 1;
var current_page = 1;
var total_page = 0;
var is_ajax_fire = 0;

manageData();

/* manage data list */
function manageData() {
    $.ajax({
        dataType: 'json',
        url: url+'api/getData.php',
        data: {page:page}
    }).done(function(data){
    	total_page = Math.ceil(data.total/10);
    	current_page = page;

    	$('#pagination').twbsPagination({
	        totalPages: total_page,
	        visiblePages: current_page,
	        onPageClick: function (event, pageL) {
	        	page = pageL;
                if(is_ajax_fire != 0){
	        	  getPageData();
                }
	        }
	    });

    	manageRow(data.data);
        is_ajax_fire = 1;

    });

}

/* Get Page Data*/
function getPageData() {
	$.ajax({
    	dataType: 'json',
    	url: url+'api/getData.php',
    	data: {page:page}
	}).done(function(data){
		manageRow(data.data);
	});
}


/* Add new Item table row */
function manageRow(data) {
	var	rows = '';
	$.each( data, function( key, value ) {
	  	rows = rows + '<tr>';
	  	rows = rows + '<td>'+value.nom+'</td>';
	  	rows = rows + '<td>'+value.prenom+'</td>';
        rows = rows + '<td>'+value.avis+'</td>';
        rows = rows + '<td>'+value.email+'</td>';
        rows = rows + '<td>'+value.mot_de_passe+'</td>';
        rows = rows + '<td>'+value.adresse+'</td>';
        rows = rows + '<td>'+value.telephone+'</td>';
        rows = rows + '<td>'+value.honoraire+'</td>';
	  	rows = rows + '<td data-id="'+value.id+'">';
        rows = rows + '<button data-toggle="modal" data-target="#edit-item" class="btn btn-primary edit-item">Edit</button> ';
        rows = rows + '<button class="btn btn-danger remove-item">Delete</button>';
        rows = rows + '</td>';
	  	rows = rows + '</tr>';
	});

	$("tbody").html(rows);
}

/* Create new Item */
$(".crud-submit").click(function(e){
    e.preventDefault();
    var form_action = $("#create-item").find("form").attr("action");
    var nom = $("#create-item").find("input[name='nom']").val();
    var prenom = $("#create-item").find("input[name='prenom']").val();
    var avis = $("#create-item").find("input[name='avis']").val();
    var email = $("#create-item").find("input[name='email']").val();
    var mot_de_passe = $("#create-item").find("input[name='mot_de_passe']").val();
    var adresse = $("#create-item").find("input[name='adresse']").val();
    var telephone = $("#create-item").find("input[name='telephone']").val();
    var honoraire = $("#create-item").find("input[name='honoraire']").val();

    if(nom != '' && prenom != '' && avis != '' && email != ''
        && mot_de_passe != '' && adresse != '' && telephone != '' && honoraire != ''){
        if (validateEmail(email) == true) {
            $.ajax({
                dataType: 'json',
                type:'POST',
                url: url + form_action,
                data:{
                    nom:nom,
                    prenom:prenom,
                    avis:avis,
                    email:email,
                    mot_de_passe:mot_de_passe,
                    adresse:adresse,
                    telephone:telephone,
                    honoraire:honoraire,
                }
            }).done(function(data){
                getPageData();
                $(".modal").modal('hide');
                toastr.success('Ajouter avec succès.', {timeOut: 5000});
                document.getElementById("FROM1").reset();
            });
        } else {
            alert("L'adresse email est invalide");
        }
    }else{
        alert("Une érreur est survenu ! l'un des champs est incorrect ou vide");
    }
});

/* Remove Item */
$("body").on("click",".remove-item",function(){
    var id = $(this).parent("td").data('id');
    var c_obj = $(this).parents("tr");

    $.ajax({
        dataType: 'json',
        type:'POST',
        url: url + 'api/delete.php',
        data:{id:id}
    }).done(function(data){
        c_obj.remove();
        toastr.success('supprimer avec succès.', {timeOut: 5000});
        getPageData();
    });

});


/* Edit Item */
$("body").on("click",".edit-item",function(){

    var id = $(this).parent("td").data('id');
    var nom =           $(this).parent("td").prev("td").prev("td").prev("td").prev("td").prev("td").prev("td").prev("td").prev("td").text();
    var prenom =        $(this).parent("td").prev("td").prev("td").prev("td").prev("td").prev("td").prev("td").prev("td").text();
    var avis =          $(this).parent("td").prev("td").prev("td").prev("td").prev("td").prev("td").prev("td").text();
    var email =         $(this).parent("td").prev("td").prev("td").prev("td").prev("td").prev("td").text();
    var mot_de_passe =  $(this).parent("td").prev("td").prev("td").prev("td").prev("td").text();
    var adresse =       $(this).parent("td").prev("td").prev("td").prev("td").text();
    var telephone =     $(this).parent("td").prev("td").prev("td").text();
    var honoraire =     $(this).parent("td").prev("td").text();

    $("#edit-item").find("input[name='nom']").val(nom);
    $("#edit-item").find("input[name='prenom']").val(prenom);
    $("#edit-item").find("input[name='avis']").val(avis);
    $("#edit-item").find("input[name='email']").val(email);
    $("#edit-item").find("input[name='mot_de_passe']").val(mot_de_passe);
    $("#edit-item").find("input[name='adresse']").val(adresse);
    $("#edit-item").find("input[name='telephone']").val(telephone);
    $("#edit-item").find("input[name='honoraire']").val(honoraire);
    $("#edit-item").find(".edit-id").val(id);
});


/* Updated new Item */
$(".crud-submit-edit").click(function(e){

    e.preventDefault();
    var form_action = $("#edit-item").find("form").attr("action");
    var nom = $("#edit-item").find("input[name='nom']").val();
    var prenom = $("#edit-item").find("input[name='prenom']").val();
    var avis = $("#edit-item").find("input[name='avis']").val();
    var email = $("#edit-item").find("input[name='email']").val();
    var mot_de_passe = $("#edit-item").find("input[name='mot_de_passe']").val();
    var adresse = $("#edit-item").find("input[name='adresse']").val();
    var telephone = $("#edit-item").find("input[name='telephone']").val();
    var honoraire = $("#edit-item").find("input[name='honoraire']").val();
    var id = $("#edit-item").find(".edit-id").val();

    if(nom != '' && prenom != '' && avis != '' && email != ''
        && mot_de_passe != '' && adresse != '' && telephone != '' && honoraire != ''){

        if (validateEmail(email) == true) {
            $.ajax({
                dataType: 'json',
                type:'POST',
                url: url + form_action,
                data:{
                    nom:nom,
                    prenom:prenom,
                    avis:avis,
                    email:email,
                    mot_de_passe:mot_de_passe,
                    adresse:adresse,
                    telephone:telephone,
                    honoraire:honoraire,
                    id:id
                }
            }).done(function(data){
                getPageData();
                $(".modal").modal('hide');
                toastr.success('Mis à jour avec succès.', {timeOut: 5000});
            });
        } else {
            alert("L'adresse email est invalide");
        }
    }else{
        alert("Une érreur est survenu ! l'un des champs est incorrect ou vide");
    }
});

function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
}
});

function computePassword() {

    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijk@lmnopqrstuvwxyz0123456789";

    for( var i=0; i < 8; i++ ){
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }

    var id = $(this).parent("td").data('id');
    $("#create-item").find("input[name='mot_de_passe']").val(text);
    $("#create-itemt").find(".create-id").val(id);
}