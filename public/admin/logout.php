<?php 
session_start();
$_SESSION['session_email'] = "";
$_SESSION['session_password'] = "";
session_destroy();

header("location:login.php");