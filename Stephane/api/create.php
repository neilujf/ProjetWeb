<?php
require 'db_config.php';

    $post = $_POST;

    $sql = "INSERT INTO Professeurs (nom,prenom,avis,email,mot_de_passe,adresse,telephone,honoraire) 
      VALUES (
          '".$post['nom']."',
          '".$post['prenom']."',
          '".$post['avis']."',
          '".$post['email']."',
          '".$post['mot_de_passe']."',
          '".$post['adresse']."',
          '".$post['telephone']."',
          '".$post['honoraire']."'
      )";

    $result = $mysqli->query($sql);
    $sql = "SELECT * FROM Professeurs Order by id desc LIMIT 1";
    $result = $mysqli->query($sql);
    $data = $result->fetch_assoc();

    echo json_encode($data);
?>