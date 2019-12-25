<?php
  session_start();
  include 'classes/Database.php';
  include 'classes/User.php';
  include 'classes/Auth.php';
   
   $auth = new Auth;
   $username = $_GET['username'];
   $password = $_GET['password'];
   $code = $auth->getCode($username);

   if($_SERVER["REQUEST_METHOD"] == "POST") {
       $authcode = str_replace(" ", NULL, $_POST['AuthCode']);
    if (hash("sha256", $code->secret.$authcode) == $code->code) {
      $diff = time() - strtotime($code->created_at);
      if(round($diff / 60) >= 10){
        $error = "This code has expired please login again";
       } else {
         $_SESSION['login_user'] = $username;
         $_SESSION['login_password'] = hash("sha256",$auth->salt.base64_decode($password));
         $auth->redirect("index.php");
       }
    } else {
       $error = "Verification code is incorrect!!";
    }
   }
   try {

   } catch (\Throwable $th) {
     //throw $th;
   }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="Botnet Coded By Black.Hacker">
    <meta name="author" content="Black.Hacker">
    <title>BlackNET - 2 Factor Authentication</title>
    <link rel="shortcut icon" href="favico.png">
    <link href="asset/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="asset/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="asset/css/sb-admin.css" rel="stylesheet">
  </head>
  <body class="bg-dark">
    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">Login</div>
        <div class="card-body">
          <form method="POST">
            <?php if(isset($error)): ?>
               <div class="alert alert-danger"><span class="fa fa-times-circle"></span><?php echo $error; ?></div>
              <?php else: ?>
                <div class="alert alert-primary"><span class="fa fa-info-circle"></span>Please check your email for the code.</div>
              <?php endif; ?>
            <div class="form-group">
              <div class="form-label-group">
                <input type="text" id="AuthCode" pattern="[0-9]{6}" name="AuthCode" class="form-control" placeholder="Verification Code" required="required">
                <label for="AuthCode">Verification Code</label>
              </div>
            </div>
            <div class="align-content-center text-center">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
          </form>
        </div>
      </div>
    </div>
    <script src="asset/vendor/jquery/jquery.min.js"></script>
    <script src="asset/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="asset/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>

  </body>

</html>
