<?php 
include 'classes/Database.php';
include 'classes/Clients.php';
if (isset($_GET['id'])) {
	$client = new Clients;
	$command = $client->getCommand($_GET['id']); 
	echo $command->command;
}
?>