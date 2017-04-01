<?php
require 'db_config.php';

$num_rec_per_page = 5;

if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };

$start_from = ($page-1) * $num_rec_per_page;

$sqlTotal = "SELECT * FROM Professeurs";
$sql = "SELECT * FROM Professeurs Order By id ";


  $result = $mysqli->query($sql);


  while($row = $result->fetch_assoc()){

     $json[] = $row;

  }

  $data['data'] = $json;


$result =  mysqli_query($mysqli,$sqlTotal);

$data['total'] = mysqli_num_rows($result);


echo json_encode($data);

?>