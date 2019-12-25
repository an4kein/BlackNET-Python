<?php 
include 'classes/Database.php';
include 'classes/User.php';
include 'classes/Mailer.php';
include 'classes/ResetPassword.php';
$key = isset($_GET['key']) ? $_GET['key'] : null;
$updatePassword = new ResetPassword;
if ($updatePassword->isExist($key) == "Key Exist") {
$data = $updatePassword->getUserAssignToToken($key);
$question = $updatePassword->getQuestionByUser($data->username);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if ($_POST['answer'] == $question->answer) {
    $updatePassword->redirect("reset.php?key=$key&answered=true");
  } else {
    $msg = "Answer is incorrect";
  }
} 
} else {
      $updatePassword->redirect("expire.php");
}
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
      <div class="card-header">Security Question</div>
      <div class="card-body">
            <?php  if(isset($msg)): ?>
                <div class="alert alert-danger" role="alert">
                  <span class="fas fa-times-circle" ></span> <?php echo $msg ?>
                </div>
             <?php endif; ?>
        <div class="text-center mb-4">

          <h4>Security Question</h4>
          <p>Please enter the answer to your security question</p>
        </div>
        <form method="POST">
            <div class="form-group">
            <label><?php echo $question->question; ?></label>
            <div class="form-label-group">
              <input type="text" name="answer" id="answer" class="form-control" placeholder="Security Question's Answer" required="required" autofocus="autofocus">
              <label for="answer">Security Question's Answer</label>
            </div>
          </div>
          <button class="btn btn-primary btn-block" type="submit" for="Form2">Next Step</button>  
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="login.php">Login Page</a>
        </div>
      </div>
    </div>
  </div>

    <?php include 'components/js.php'; ?>

</body>

</html>
