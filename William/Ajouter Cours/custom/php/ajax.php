<?php
require_once('config.php');

if(isset($_POST['requete'])) {

    $requete = $_POST['requete'];

    // ajouter
    if($requete == "ajouter") {

        parse_str($_POST['form_val'], $form_val);

        $req = $bdd->prepare('INSERT INTO cours(date_debut, date_fin, lieu, capacite, id_formation) VALUES(:date_debut, :date_fin, :lieu, :capacite, :formation)');
        $req->execute($form_val);
    }

    //recuperer
    if($requete == "recuperer"){
        $formations_request = $bdd->query('SELECT id, nom FROM formations');
        while ($formations_data = $formations_request->fetch()) {
            $array_name[] = $formations_data['nom'];
        }
        $formations_request->closeCursor();

        $req = $bdd->prepare('SELECT * FROM cours');
        $req->execute();

        if($req->rowCount()>0) {
            ?>
            <table class="table table-hover table-striped " id="cours">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date de début</th>
                        <th>Date de fin</th>
                        <th>Lieu</th>
                        <th>Capacité</th>
                        <th>Formation</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <?php

                while($serveur_data = $req->fetch()) {

                    ?>

                    <tr>
                        <th><?php echo $serveur_data['id']; ?></th>
                        <td><?php echo $serveur_data['date_debut']; ?></td>
                        <td><?php echo $serveur_data['date_fin']; ?></td>
                        <td><?php echo $serveur_data['lieu']; ?></td>
                        <td><?php echo $serveur_data['capacite']; ?></td>
                        <td><?php echo $array_name[$serveur_data['id_formation'] - 1]; ?></td>
                        <td>
                            <div class="btn-group actions">
                                <button type="button" class="btn btn-sm btn-default" title="Modifier le cours" onClick="actions('edit',<?php echo $serveur_data['id']; ?>);" ><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                <button type="button" class="btn btn-sm btn-default" title="Supprimer le cours" onClick="actions('delete',<?php echo $serveur_data['id']; ?>);"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tbody>
                </tbody>
            </table>
            <?php

            $req->closeCursor();
        }
        else{
            ?>
            <div class="alert alert-danger">
                <strong>Échec !</strong> Aucune données dans la base de données.
            </div>
            <?php
        }
    }

    // supprimer
    if($requete == "delete") {

        $req = $bdd->prepare('DELETE FROM cours WHERE id=:id');
        $req->execute(array("id" => $_POST['id']));

    }

    //recuperer par id
    if($requete == "recuperer-id") {

        $req = $bdd->prepare('SELECT * FROM cours WHERE id=:id');
        $req->execute(array("id" => $_POST['id']));

        echo json_encode($req->fetch());

        $req->closeCursor();
    }

    // modifier
    if($requete == "edit") {

        parse_str($_POST['form_val'], $form_val);
        $req = $bdd->prepare('UPDATE cours SET date_debut = :date_debut, date_fin = :date_fin, lieu = :lieu, capacite = :capacite, id_formation = :formation WHERE id = :id');
        $req->execute($form_val);

    }
}
?>