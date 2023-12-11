<?php
session_start();
if (!isset($_SESSION['admin_name']) || ($_SESSION['admin_name'])!='true'){
        die('<script>alert("您不是管理员!");window.location="admin.php";</script>');
}
$time = mktime();
if ($time - $_SESSION['login_time'] > 600){
    die('<script>window.location="admin.php";</script>');
}else{
    $_SESSION['login_time'] = mktime();
}
?>