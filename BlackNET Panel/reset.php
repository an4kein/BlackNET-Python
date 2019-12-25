<?php 
session_start();
include 'classes/Database.php';
include 'classes/User.php';
include 'classes/Mailer.php';
include 'classes/ResetPassword.php';
$key = $_GET['key'];
$updatePassword = new ResetPassword;
if ($updatePassword->isExist($key) == "Key Exist") {
$data = $updatePassword->getUserAssignToToken($key);
$question = $updatePassword->isQuestionEnabled($data->username);
$answerd = isset($_GET['answered']) ? $_GET['answered'] : "false";
if ($question != false) {
  if ($answerd !="true") {
      $updatePassword->redirect("question.php?username=$data->username&&key=$key");
  }
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $Password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];
  if ($Password == $confirmPassword) {
    $msg  = $updatePassword->updatePassword($key,$data->username,$_POST['password']);
  } else {
    $err = "Password confirm is incorrect";
  }
} 
} else {
      $updatePassword->redirect("expire.php");
}
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>BlackNET - Reset Password</title>
  <link rel="shortcut icon" href="favico.png">
  <?php include 'components/css.php'; ?>

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Reset Password</div>
      <div class="card-body">
            <?php if(isset($msg)): ?>
              <div class="alert alert-primary" role="alert">
               <span class="fas fa-info-circle" ></span> <?php echo $msg ?>
              </div>
            <?php endif; ?>
            <?php if(isset($err)): ?>
              <div class="alert alert-danger" role="alert">
                <span class="fas fa-times-circle" ></span> <?php echo $err ?>
                </div>
            <?php endif; ?>
        <div class="text-center mb-4">

          <h4>Reset Password</h4>
          <p>Please enter a strong password that contains 8 characters and at least one special character</p>
        </div>
        <form method="POST" action="">

          <div class="form-group">
            <div class="form-label-group">
              <input type="password" name="password" id="password" class="form-control" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Must contain at least one number, one uppercase letter, lowercase letter, one character, and at least 8 or more characters" placeholder="Enter your new password" required="required" autofocus="autofocus">
              <label for="password">New Password</label>
            </div>
          </div>

          <div class="form-group">
            <div class="form-label-group">
              <input type="password" name="confirmPassword" id="confirmPassword" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Must contain at least one number, one uppercase letter, lowercase letter, one special character, and at least 8 or more characters" class="form-control" placeholder="Enter your password again" required="required" autofocus="autofocus">
              <label for="confirmPassword">Confirm Password</label>
            </div>
        </div>
          <button class="btn btn-primary btn-block" type="submit">Reset Password</button>

        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="login.php">Login Page</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <?php include 'components/js.php'; ?>

</body>

</html>
