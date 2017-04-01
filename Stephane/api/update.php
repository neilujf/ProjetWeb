<?php
require 'db_config.php';


  $id  = $_POST["id"];
  $post = $_POST;

  $sql = "UPDATE Professeurs SET 
          nom = '".$post['nom']."'
          ,prenom = '".$post['prenom']."' 
          ,avis = '".$post['avis']."' 
          ,email = '".$post['email']."' 
          ,mot_de_passe = '".$post['mot_de_passe']."' 
          ,adresse = '".$post['adresse']."' 
          ,telephone = '".$post['telephone']."' 
          ,honoraire = '".$post['honoraire']."' 
          WHERE id = '".$id."'";

  $result = $mysqli->query($sql);


  $sql = "SELECT * FROM Professeurs WHERE id = '".$id."'";

  $result = $mysqli->query($sql);

  $data = $result->fetch_assoc();


echo json_encode($data);
?>