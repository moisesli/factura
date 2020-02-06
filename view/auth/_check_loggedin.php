<?php

include_once "_class_auth.php";
$auth = new Auth;
if (!$auth->loggedin()){
  header("Location: /view/auth/login.php");
}

//echo 'moises';

?>
