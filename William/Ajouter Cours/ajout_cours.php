<?php
require_once('custom/php/config.php');
?><!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Ajouter un cours</title>
    <!-- jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Date time picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/css/datepicker3.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/js/locales/bootstrap-datepicker.fr.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <!-- Data Tables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-3.1.3/pdfmake-0.1.27/dt-1.10.15/af-2.2.0/b-1.3.1/b-colvis-1.3.1/b-flash-1.3.1/b-html5-1.3.1/b-print-1.3.1/cr-1.3.3/fc-3.2.2/fh-3.1.2/kt-2.2.1/r-2.1.1/rg-1.0.0/rr-1.2.0/sc-1.4.2/se-1.2.2/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-3.1.3/pdfmake-0.1.27/dt-1.10.15/af-2.2.0/b-1.3.1/b-colvis-1.3.1/b-flash-1.3.1/b-html5-1.3.1/b-print-1.3.1/cr-1.3.3/fc-3.2.2/fh-3.1.2/kt-2.2.1/r-2.1.1/rg-1.0.0/rr-1.2.0/sc-1.4.2/se-1.2.2/datatables.min.js"></script>
    <!-- Fonctions affichage et actions -->
    <script type="text/javascript" src="custom/js/script.js"></script>
    <script type="text/javascript" src="custom/lib/datetimepicker/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="custom/lib/datetimepicker/bootstrap-datetimepicker-fr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="custom/lib/datetimepicker/bootstrap-datetimepicker.min.css"/>
</head>

<body>
<!-- barre de navigation -->
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <h2>Gestion des cours</h2>
        </div>
        <div class="collapse navbar-collapse">
            <button type="button" id="showFormAdd" class="btn btn-sm btn-primary navbar-btn navbar-right"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Ajouter un cours</button>
        </div>
    </div>
</nav>

<!-- Formulaire ajout -->

<div class="container" id="formAdd">
    <div class="jumbotron">
        <h1><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Ajout d'un cours</h1>
        <form>
            <fieldset>
                <legend>Informations</legend>
                <div class="form-group">
                    <div id="datetimepicker1" class="input-append date">
                        <label for="date_debut">Date de début</label>
                        <div class="input-group date">
                            <input data-format="yyyy/MM/dd hh:mm" type="text" class="form-control" id="date_debut" name="date_debut" placeholder="YYYY-MM-DD HH:MM" value="" onchange="verifForm()"/>
                            <span class="add-on input-group-addon glyphicon glyphicon-calendar"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div id="datetimepicker2" class="input-append date">
                        <label for="date_fin">Date de fin</label>
                        <div class="input-group date">
                            <input data-format="yyyy/MM/dd hh:mm" type="text" class="form-control" id="date_fin" name="date_fin" placeholder="YYYY-MM-DD HH:MM" value="" onchange="verifForm()"/>
                            <span class="add-on input-group-addon glyphicon glyphicon-calendar"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="lieu">Lieu</label>
                    <input type="text" class="form-control" id="lieu" name="lieu" placeholder="Lieu ou salle où aura lieu le cours" value="" onchange="verifForm()"/>
                </div>
                <div class="form-group">
                    <label for="capacite">Capacité</label>
                    <input type="number" step="1" class="form-control" id="capacite" name="capacite" placeholder="Nombre d'élèves au maximum" min="0" max="2147483647" value="" onchange="verifForm()"/>
                </div>
                <div class="form-group">
                    <label for="formation">Formation</label>
                    <select class="form-control" name="formation" id="formation" onchange="verifForm()">
                        <option value="" disabled selected hidden>Sélectionner une formation</option>
                        <?php
                        $formations_request = $bdd->query('SELECT id, nom FROM formations');
                        while ($formations_data = $formations_request->fetch())
                        {
                            ?>
                            <option value="<?php echo $formations_data['id']; ?>"> <?php echo $formations_data['nom']; ?></option>
                            <?php
                        }
                        $formations_request->closeCursor();
                        ?>
                    </select>
                </div>
            </fieldset>
            <button type="button" id="button_send" name="add_button_send" class="btn btn-lg btn-primary">Ajouter le cours</button>
            <button type="reset" id="button_cancel" class="btn btn-lg btn-danger">Annuler</button>
        </form>
        <br>
    </div>
</div>

<!-- Formulaire modification -->

<div class="container" id="formEdit">
    <div class="jumbotron">
        <h1><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Modification du cours #<b></b></h1>
        <form>
            <input type="hidden" id="id" name="id">
			<fieldset>
                <legend>Informations</legend>
                <div class="form-group">
                    <div id="datetimepicker1" class="input-append date">
                        <label for="date_debut">Date de début</label>
                        <div class="input-group date">
                            <input data-format="yyyy/MM/dd hh:mm" type="text" class="form-control" id="date_debut" name="date_debut" placeholder="YYYY-MM-DD HH:MM" value="" onchange="verifForm()"/>
                            <span class="add-on input-group-addon glyphicon glyphicon-calendar"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div id="datetimepicker2" class="input-append date">
                        <label for="date_fin">Date de fin</label>
                        <div class="input-group date">
                            <input data-format="yyyy/MM/dd hh:mm" type="text" class="form-control" id="date_fin" name="date_fin" placeholder="YYYY-MM-DD HH:MM" value="" onchange="verifForm()"/>
                            <span class="add-on input-group-addon glyphicon glyphicon-calendar"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="lieu">Lieu</label>
                    <input type="text" class="form-control" id="lieu" name="lieu" placeholder="Lieu ou salle où aura lieu le cours" value="" onchange="verifForm()"/>
                </div>
                <div class="form-group">
                    <label for="capacite">Capacité</label>
                    <input type="number" step="1" class="form-control" id="capacite" name="capacite" placeholder="Nombre d'élèves au maximum" min="0" max="2147483647" value="" onchange="verifForm()"/>
                </div>
                <div class="form-group">
                    <label for="formation">Formation</label>
                    <select class="form-control" name="formation" id="formation" onchange="verifForm()">
                        <option value="" disabled selected hidden>Sélectionner une formation</option>
                        <?php
                        $formations_request = $bdd->query('SELECT id, nom FROM formations');
                        while ($formations_data = $formations_request->fetch())
                        {
                            ?>
                            <option value="<?php echo $formations_data['id']; ?>"> <?php echo $formations_data['nom']; ?></option>
                            <?php
                        }
                        $formations_request->closeCursor();
                        ?>
                    </select>
                </div>
            </fieldset>
            <button type="button" id="button_send" name="edit_button_send" class="btn btn-lg btn-primary">Modifier le cours</button>
            <button type="reset" id="button_cancel" class="btn btn-lg btn-danger">Annuler</button>
        </form>
        <br>
    </div>
</div>

<!-- Tableau des cours -->
<div class="container" id="container-table">
</div>
</body>
</html>