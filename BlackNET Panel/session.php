<?php
session_start();
include 'classes/Database.php';
include 'classes/User.php';

$database = new Database;
$database->dataExist();

$user = new User;
$user_check = isset($_SESSION['login_user']) ? $_SESSION['login_user'] : null;
$password_check = isset($_SESSION['login_password']) ? $_SESSION['login_password'] : null;

if(!(isset($_SESSION['last_action']))){
  $_SESSION['last_action'] = time();
}

if(isset($_SESSION['login_user']) && $user_check != null){
    $data = $user->getUserData($user_check);    
}

if(empty($_SESSION['key'])){
  $_SESSION['key'] = uniqid(rand(), true);
}

if (!isset($_SESSION['current_ip'])) {
  $_SESSION['current_ip'] = $_SERVER["REMOTE_ADDR"];
}

if (!(isset($csrf))) {
  $csrf = hash_hmac('sha256', "eVfLOm3DT3PhYIlYCKgAdoXrqLCTQ9", $_SESSION['key'].session_id().$_SESSION["current_ip"]);
}

if(!isset($_SESSION['login_user']) || !isset($_SESSION['login_password']) || !isset($_SESSION["current_ip"]) || !isset($_SESSION['key'])){
  $database->redirect("login.php");
}

$expireAfter = 60;
if(isset($_SESSION['last_action'])){
  $secondsInactive = time() - $_SESSION['last_action'];
  $expireAfterSeconds = $expireAfter * 60;

  if($secondsInactive >= $expireAfterSeconds){
    $database->redirect("logout.php");
  }
}

$current_username = isset($data->username) ? $data->username : null;
$current_password = isset($data->password) ? $data->password : null;

if ($user_check != $current_username || $password_check != $current_password){
    if (isset($_GET['msg']) && $_GET['msg'] == "yes"){ $database->redirect("logout.php?msg=update"); }
    $database->redirect("logout.php");
}
?>