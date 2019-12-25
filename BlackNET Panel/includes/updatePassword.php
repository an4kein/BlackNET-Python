<?php 
include '../session.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if ($csrf != $_POST['csrf']){
	   $database->redirect("../changePassword.php?msg=csrf");
	} else {
	  $id = $_POST['id'];
	  $oldusername = $_POST['oldUsername'];
	  $username = $_POST['Username'];
	  $email = $_POST['Email'];
	  $auth = isset($_POST['auth-state']) ? $_POST['auth-state'] : '';
	  $question = $_POST['questions'];
	  $answer = $_POST['answer'];
	  $sqenable = isset($_POST['sqenable']) ? $_POST['sqenable'] : '';
	  
	  if (!$_POST['Password'] || $_POST['Password'] == "") {
	  	$password = "No change";
	  } else {
	  	$password = $_POST['Password'];
	  }
	  $msg = $user->updateUser($id,$oldusername,$username,$email,$password,$auth,$question,$answer,$sqenable);
	  $database->redirect("../changePassword.php?msg=yes");
	}

}
?>
