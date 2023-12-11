<?php
error_reporting(0);
session_start();
require('config.php');

function filter($str){
    if (preg_match('/"select|insert|and|or|#|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile"/i',$str)){
        echo '<script>alert("非法参数!");history.go(-1);</script>';
        echo '<script>window.location="login.php";</script>';
        exit(0);
    }
}
$user = trim($_POST['username']);
$pass = md5(trim($_POST['password']));
$team = trim($_POST['teamname']);
$conn = new mysqli($servername,$db_username,$db_password,$dbname);
if($conn->connect_error){
    die("数据库连接失败:".$conn->connect_error);
    exit(0);
}else{
    // if ($user == ''){
    //     echo '<script>alert("请输入用户名");history.go(-1);</script>';
    //     exit(0);
    // }
    // if ($pass == ''){
    //     echo '<script>alert("请输入密码");history.go(-1);</script>';
    //     exit(0);
    // }
    // if ($team == ''){
    //     echo '<script>alert("请输入战队名");history.go(-1);</script>';
    //     exit(0);
    // }

    filter($user);
    filter($pass);
    filter($team);
}
$arrays = array(array('one'=>'repeat','two'=>'success'));
$sql = "select login_name,login_pass,team_info from platform_user where login_name = '$user' && login_pass = '$pass' && team_info='$team'";
$result = $conn->query($sql);
$number = mysqli_num_rows($result);
if ($number){
    $_SESSION['username'] = 'true';
    $_SESSION['UserName'] = $user;
    $_SESSION['TeamName'] = $team;
    $_SESSION['login_time'] = mktime();
    die('success');
}else{
    die('error');
    exit();
}
?>