<?php
include 'classes/Database.php';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
$query = '';
$sqlScript = file('blacknet.sql');
$datbase = new Database;
$pdo = $datbase->Connect();
foreach ($sqlScript as $line){
  $startWith = substr(trim($line), 0 ,2);
  $endWith = substr(trim($line), -1 ,1);  
  if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
    continue;
  } 
  $query = $query . $line;
  if ($endWith == ';') {
    $stmt = $pdo->query($query) or die('Problem in executing the SQL query <b>' . $query. '</b></div>');
    $query= '';
  }
}
$msg = 'SQL file imported successfully';
}
?> 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>BlackNET - Installation</title>
    <link href="asset/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="asset/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="asset/css/sb-admin.css" rel="stylesheet">
  </head>
  <body class="bg-dark">
    <div class="container pt-3">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">Install</div>
        <div class="card-body">
          <form method="POST">
              <?php if (isset($msg)): ?>
                <div class="alert alert-success"><?php echo $msg ?></div>
             <?php endif; ?>
      <div class="alert alert-primary text-center border-primary">
          <p class="lead h2">
            <b>this page going to install BlackNET default settings<br> 
            <hr>
            <p class="h3">admin login details</p>
            <ul class="list-unstyled h4">
              <li class="">Username: admin</li>
              <li class="">Password: admin</li>
            </ul>
            <hr/>
            <p>Please change the admin information for better security.</p>
          </b></p>
         </div>
            <button type="submit" class="btn btn-primary btn-block">Start Installation</button>
          </form>
        </div>
      </div>
    </div>
    <script src="asset/vendor/jquery/jquery.min.js"></script>
    <script src="asset/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="asset/vendor/jquery-easing/jquery.easing.min.js"></script>

  </body>

</html>
