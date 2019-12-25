<?php
include 'classes/Database.php';
include 'classes/Clients.php';
include 'getcontery.php';

$counter = new Clients;
$arrays = [];
foreach ($countries as $data => $value) {
	array_push($arrays, ["id" => $data,"name" => $value, "value"=>$counter->countClientByCountry($data)]);
}
echo json_encode($arrays);
?>