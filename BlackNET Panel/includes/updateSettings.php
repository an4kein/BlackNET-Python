<?php
include('../session.php');
require '../classes/Settings.php';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$settings = new Settings;
	if ($csrf != $_POST['csrf']) {
		$database->redirect("../settings.php?msg=csrf");
	} else {
	  $id = $_POST['id'];
	  $recaptchaprivate = $_POST['reCaptchaPrivate'];
	  $recaptchapublic = $_POST['reCaptchaPublic'];
	  $status = isset($_POST['status-state']) ? $_POST['status-state'] : '';
	  $panel = isset($_POST['panel-state']) ? $_POST['panel-state'] : '';
	  $msg = $settings->updateSettings($id,$recaptchaprivate,$recaptchapublic,$status,$panel);
	  $database->redirect("../settings.php?msg=yes");
	}
}
?>
