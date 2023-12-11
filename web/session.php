<?php
session_start();
if (!isset($_SESSION['username']) || ($_SESSION['username'])!='true'){
    die('<script>window.location="login.php?result=nologin";</script>');
}
$time = mktime();
if ($times - $_SESSION['login_time'] > 600){
    die('<script>window.location="login.php";</script>');
}else{
    $_SESSION['login_time'] = mktime();
}
?>
