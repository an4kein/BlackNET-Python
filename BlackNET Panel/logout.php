<?php
    session_start();
   if(session_unset() && session_destroy()) {
    if (isset($_GET['msg'])) {
    	exit(header("location: login.php?msg=yes"));
    } else {
    	exit(header("location: login.php"));
    }
   }
?>