<!DOCTYPE html>
<html>
<head>
	<title>PHP Jquery Ajax CRUD Example</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.3.1/jquery.twbsPagination.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

	<script type="text/javascript">
    	var url = "";
    </script>
    <style type="text/css">
    	.modal-dialog, .modal-content{
		z-index:1051;
		}
    </style>
    <script src="js/item-ajax.js"></script>
</head>
<body>

	<div class="container">
		<div class="row">
		    <div class="col-lg-12 margin-tb">					
		        <div class="pull-left">
		            <h2>Espace de gestion</h2>
		        </div>
		        <div class="pull-right">
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-item" onclick="computePassword();">
					  Create Item
				</button>
		        </div>
		    </div>
		</div>

		<div class="panel panel-primary">
			  <div class="panel-heading">Liste des enseignants</div>
			  <div class="panel-body">
				<table class="table table-bordered">
					<thead>
					    <tr>
						    <th>nom</th>
                            <th>prenom</th>
                            <th>avis</th>
                            <th>email</th>
                            <th>mot_de_passe</th>
                            <th>adresse</th>
                            <th>telephone</th>
                            <th>honoraire</th>
						<th width="200px">Action</th>
					    </tr>
					</thead>
					<tbody>
					</tbody>
				</table>

		<ul id="pagination" class="pagination-sm"></ul>
			  </div>
	  </div>

	    <!-- Create Item Modal -->
		<div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		        <h4 class="modal-title" id="myModalLabel">Create Item</h4>
		      </div>

		      <div class="modal-body">
		      		<form id="FROM1" data-toggle="validator" action="api/create.php" method="POST">
                        <input type="hidden" name="id" class="create-id">
		      			<div class="form-group">
							<label class="control-label" for="title">Nom:</label>
							<input type="text" name="nom" class="form-control" data-error="Please enter title." required />
							<div class="help-block with-errors"></div>
						</div>
                        <div class="form-group">
                            <label class="control-label" for="title">Prénom:</label>
                            <input type="text" name="prenom" class="form-control" data-error="Please enter title." required />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="title">Avis:</label>
                            <input type="text" name="avis" class="form-control" data-error="Please enter title." required />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="title">Email:</label>
                            <input type="text" name="email" class="form-control" data-error="Please enter title." required />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="title">Mot de passe:</label>
                            <input id="createPassWord" type="text" name="mot_de_passe" class="form-control" data-error="Please enter title." required />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="title">Adresse:</label>
                            <input type="text" name="adresse" class="form-control" data-error="Please enter title." required />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="title">Télephone:</label>
                            <input type="text" name="telephone" class="form-control" data-error="Please enter title." required />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="title">Honoraire:</label>
                            <input type="text" name="honoraire" class="form-control" data-error="Please enter title." required />
                            <div class="help-block with-errors"></div>
                        </div>

						<div class="form-group">
							<button type="submit" class="btn crud-submit btn-success">Submit</button>
						</div>

		      		</form>

		      </div>
		    </div>

		  </div>
		</div>

		<!-- Edit Item Modal -->
		<div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		        <h4 class="modal-title" id="myModalLabel">Edit Item</h4>
		      </div>

		      <div class="modal-body">
		      		<form data-toggle="validator" action="api/update.php" method="put">
		      			<input type="hidden" name="id" class="edit-id">
		      			<div class="form-group">
							<label class="control-label" for="title">nom:</label>
							<input type="text" name="nom" class="form-control" data-error="Le nom de l'enseignant." required />
							<div class="help-block with-errors"></div>
						</div>
                        <div class="form-group">
                            <label class="control-label" for="title">Prénom:</label>
                            <input type="text" name="prenom" class="form-control" data-error="Le prémom." required />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="title">Avis:</label>
                            <input type="text" name="avis" class="form-control" data-error="Avis sur l'enseignant" required />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="title">Email:</label>
                            <input type="text" name="email" class="form-control" data-error="Email de l'enseignant" required />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="title">Mot de passe:</label>
                            <input type="text" name="mot_de_passe" class="form-control" data-error="Please enter title." required />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="title">Adresse:</label>
                            <input type="text" name="adresse" class="form-control" data-error="L'adresse de l'enseignant" required />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="title">Télephone:</label>
                            <input type="text" name="telephone" class="form-control" data-error="Le numéro de téléphone." required />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="title">Honoraire:</label>
                            <input type="text" name="honoraire" class="form-control" data-error="La rénumération en €." required />
                            <div class="help-block with-errors"></div>
                        </div>
						<div class="form-group">
							<button type="submit" class="btn btn-success crud-submit-edit">Submit</button>
						</div>
		      		</form>
		      </div>
		    </div>
		  </div>
		</div>

	</div>
</body>
</html>