<?php
session_start();
require('config.php');

function filter($str){
    if (preg_match('/"select|insert|and|or|#|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile"/i', $str)) {
        echo '<script>alert("非法参数!");history.go(-1);</script>';
        echo '<script>window.location="login.php";</script>';
        exit(0);
    }
}

$admin_user = trim($_POST['username']);
$admin_pass = md5(trim($_POST['password']));
$conn = new mysqli($servername,$db_username,$db_password,$dbname);
if($conn->connect_error){
    die("数据库连接失败:".$conn->connect_error);
    exit(0);
}else{
    if ($admin_user == ''){
        echo '<script>alert("请输入用户名");history.go(-1);</script>';
        exit(0);
    }
    if ($admin_pass == ''){
        echo '<script>alert("请输入密码");history.go(-1);</script>';
        exit(0);
    }

    filter($admin_user);
    filter($admin_pass);
}
$sql = "select username,password from admin_info where username = '$admin_user' and password = '$admin_pass'";
$result = $conn->query($sql);
$number = mysqli_num_rows($result);
if ($number){
    $_SESSION['admin_name'] = 'true';
    $_SESSION['login_time'] = mktime();
    die('<script>alert("登入成功!");window.location="admin_panel.php";</script>');
}else{
    die('<script>alert("用户名或密码错误!");history.go(-1);window.location="admin.php";</script>');
    exit();
}
?>
