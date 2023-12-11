<?php
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>测试平台</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="js/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
<canvas class="cavs" width="1575" height="1337"></canvas>

<div class="loginmain">
    <div class="login-title">
        <span>管理员登录</span>
    </div>
    <form action="admin_judeg.php" method="post">
    <div class="login-con">
        <div class="login-user">
            <div class="icon">
                <img src="image/user_icon_copy.png" alt="">
            </div>
            <input type="text" name="username" placeholder="用户名" autocomplete="off">
        </div>
        <div class="login-pwd">
            <div class="icon">
                <img src="image/lock_icon_copy.png" alt="">
            </div>
            <input type="password" name="password" placeholder="密码" autocomplete="off" value="">
        </div>
        <div class="login-btn">
            <input type="submit" value="登录">
        </div>
    </div>
    </form>
</div>
</body>
</html>

<script src="js/jquery.min.js"></script>
<script src="js/ban.js"></script>
