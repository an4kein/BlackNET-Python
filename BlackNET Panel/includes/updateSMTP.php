<?php 
include_once '../session.php';
include_once '../classes/Mailer.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$smtp = new Mailer;
	if ($csrf != $_POST['csrf']) {
		$database->redirect("../settings.php?msg=csrf");
	} else {
	  $status = isset($_POST['smtp-state']) ? $_POST['smtp-state'] : '';
	  $msg = $smtp->setSMTP(
	  	$_POST['id'],
	  	$_POST['SMTPHost'],
	  	$_POST['SMTPUser'],
	  	$_POST['SMTPPassword'],
	  	$_POST['SMTPPort'],
	  	$_POST['security'],
	  	$status
	  );
	  $database->redirect("../settings.php?msg=yes");
	}
}
?>
