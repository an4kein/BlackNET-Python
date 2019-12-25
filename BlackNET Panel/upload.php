<?php
$id = base64_decode($_GET['id']);
$forbidden = array('b374k.php','c99.php','r57.php','wso.php','webadmin.php','weevely.php');
$extension = array("jpeg","jpg","png","sqlite","txt","tmp","dat");
$mime_types = array('image/jpeg','image/png','application/x-sqlite3','text/plain','application/octet-stream','zz-application/zz-winassoc-dat','application/x-bitcoin-wallet-backup');
$ext = strtolower(pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION));

if (!in_array($_FILES['file']['name'], $forbidden)) {
  if (in_array($ext, $extension)) {
    $filesize = $_FILES['file']['size'];
    $type = getMime($_FILES["file"]["tmp_name"]);
    $browsermime = mime_content_type($_FILES["file"]["tmp_name"]);

   if (in_array($type,$mime_types)) {
    if ($browsermime == $type) {
      if (is_uploaded_file($_FILES["file"]["tmp_name"])) {
         move_uploaded_file($_FILES["file"]["tmp_name"], "upload/$id/" . $_FILES["file"]["name"]);
     }
    }
   }
  }
 }

function getMime($name){
      $finfo = finfo_open(FILEINFO_MIME_TYPE);
      $mtype = finfo_file($finfo,$name);
      finfo_close($finfo);
      return $mtype;
}
?>