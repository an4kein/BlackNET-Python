<?php
include 'session.php';
include 'classes/Mailer.php';

//$current_username is in session.php 
$question = $user->getQuestionByUser($current_username);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
     <link rel="shortcut icon" href="favico.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>BlackNET - User Settings</title>
    <?php include_once 'components/css.php'; ?>
    <link href="asset/css/bootstrap-switch.css" rel="stylesheet">
    
    <style type="text/css">
    @media (min-width: 1200px) {
        .container{
            max-width: 500px;
        }
    }
      .sticky{
        display: -webkit-box;
        display: -ms-flexbox;
        background-color: #e9ecef;
        height: 80px;
        right: 0;
        bottom: 0; 
        position: absolute;
        display: flex;
        width: 100%;
        flex-shrink: none;
      }
    </style>
  </head>

  <body id="page-top">

  <?php include_once 'components/header.php'; ?>


    <div id="wrapper">
      <div id="content-wrapper">
        <div class="container-fluid">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#">User Settings</a>
            </li>
          </ol>
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas  fa-user-circle"></i>
              Update Password</div>
          <form method="POST" action="includes/updatePassword.php">
            <div class="card-body">
              <div class="container">
              <?php if (isset($_GET['msg']) && $_GET['msg'] === "yes"): ?>
                <div class="alert alert-success" role="alert">
                  <span class="fa fa-check-circle"></span> User settings has been updated
                </div>
              <?php endif; ?>

              <?php if(isset($_GET['msg']) && $_GET['msg'] === "csrf"): ?>
                <div class="alert alert-danger">
                  <span class="fa fa-times-circle"></span> CSRF Token is invalid.
                </div>
              <?php endif; ?>
            </div>
              <div class="container">
                <div class="align-content-center justify-content-center">
                <input hidden="" value="<?php echo $data->id ?>" name="id" id="id">
                <input type="text" name="csrf" id="csrf" hidden="" value="<?php  echo($csrf);  ?>">
                <div class="form-group">        
                    <input type="text" name="oldUsername" id="oldUsername" value="<?php echo $data->username; ?>" hidden="">     
                  <div class="form-label-group">
                    <input class="form-control" type="text" id="Username" name="Username" placeholder="Username" value="<?php echo $data->username; ?>">
                    <label for="Username">Username</label>
                  </div>
                </div>

                <div class="form-group">             
                  <div class="form-label-group">
                    <input class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please Enter a vlid Email" type="email" id="Email" name="Email" placeholder="Email Address" value="<?php echo $data->email; ?>" />
                    <label for="Email">Email Address</label>
                  </div>
                </div>

                  <div class="form-group">
                   <div class="form-label-group">
                     <input class="form-control" type="password" title="Must contain at least one number, one uppercase letter, lowercase letter, one special character, and at least 8 or more characters" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" id="Password" name="Password" placeholder="New Password">
                    <label for="Password">New Password</label>
                  </div>
                  <small>Keep it empty if you do not want change the password.</small>
                  </div>

                  <div class="form-group">             
                    <div class="form-group">
                       <label for="switch-state">Enable 2FA: </label>
                      <input class="bootstrap-switch" id="auth-state" name="auth-state" type="checkbox" data-size="small" <?php if ($data->s2fa == "on") { echo 'checked'; } ?>>
                    </div>
                  </div>
                  <div class="form-group">
                  <div class="form-group">             
                    <div class="form-group">
                       <label for="switch-state">Enable Security Question: </label>
                      <input class="bootstrap-switch" id="sqenable" name="sqenable" type="checkbox" data-size="small" <?php if ($question->sqenable == "on") { echo 'checked'; } ?>>
                    </div>
                  </div>
                    <div>
                      <select name="questions" id="questions" class="form-control">
                        <option <?php if($question != null && $question->question == "Select a Security Question"){ echo "selected"; } ?> value="Select a Security Question">Select a Security Question</option>
                        <option <?php if($question != null && $question->question == "What was your childhood nickname?"){ echo "selected"; } ?> value="What was your childhood nickname?">What was your childhood nickname?</option>
                        <option <?php if($question != null && $question->question == "What is the name of your favorite childhood friend?"){ echo "selected"; } ?> value="What is the name of your favorite childhood friend?">What is the name of your favorite childhood friend?</option>
                        <option <?php if($question != null && $question->question == "What was the name of your first stuffed animal?"){ echo "selected"; } ?> value="What was the name of your first stuffed animal?"> What was the name of your first stuffed animal?</option>
                        <option <?php if($question != null && $question->question == "Where were you when you had your first kiss?"){ echo "selected"; } ?> value="Where were you when you had your first kiss?"> Where were you when you had your first kiss?</option>
                        <option <?php if($question != null && $question->question == "What is the name of the company of your first job?"){ echo "selected"; } ?> value="What is the name of the company of your first job?"> What is the name of the company of your first job?</option>
                        <option <?php if($question != null && $question->question == "What was your favorite place to visit as a child?"){ echo "selected"; } ?> value="What was your favorite place to visit as a child?">What was your favorite place to visit as a child?</option>
                        <option <?php if($question != null && $question->question == "What was your dream job as a child?"){ echo "selected"; } ?> value="What was your dream job as a child?">What was your dream job as a child?</option>
                        <option <?php if($question != null && $question->question == "What is your preferred musical genre?"){ echo "selected"; } ?> value="What is your preferred musical genre?">What is your preferred musical genre?</option>
                        <option <?php if($question != null && $question->question == "What is your favorite team?"){ echo "selected"; } ?> value="What is your favorite team?"> What is your favorite team?</option>
                        <option <?php if($question != null && $question->question == "What is your father's middle name?"){ echo "selected"; } ?> value="What is your father's middle name?">What is your father's middle name?</option>
                      </select>
                    </div>
                  </div>
                <div class="form-group">             
                  <div class="form-label-group">
                    <input class="form-control" type="text" id="answer" name="answer" placeholder="Answer the question" value="<?php if(!$question == null){ echo($question->answer); } ?>" />
                    <label for="answer">Answer the question</label>
                  </div>
                </div>
                  <button class="btn btn-primary btn-block">Update your information</button>
                </div>
            </div>

          </div>
      </form>
        </div>

      <?php include_once 'components/footer.php'; ?>


    <?php include_once 'components/js.php'; ?>
    <script src="asset/js/bootstrap-switch/main.js"></script>
    <script src="asset/js/bootstrap-switch/highlight.js"></script>
    <script src="asset/js/bootstrap-switch/bootstrap-switch.js"></script>
  </body>
</html>
