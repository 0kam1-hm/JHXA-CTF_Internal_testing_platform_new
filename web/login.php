<?php
error_reporting(0);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>江环信安CTF内部测试平台</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/message.css">
     <script src="./js/message.min.js"></script>
    <script src="js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="js/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <style>
        html,body{
            width: 100%;
            height: 100%;
            background: url("image/bg2.jpeg") no-repeat;
            background-size: 100% 100%;

	}
	#to{
		width:100%;
		margin-top:7%;
	}
	.one_title{
	    color:white;
	    width:385px;
	    margin:0px auto;
            box-shadow: none;
        }
    </style>
</head>
<body>
<canvas class="cavs" width="1575" height="1337"></canvas>

<!--<div class="alert alert-primary" id="alert-primary" role="alert" style="width: 200px;text-align: center;margin-left: 850px">
    登入成功
</div>-->
<div id="to">
<div class="one_title">
    <h2>江环信安CTF内部测试平台</h2>
</div>
</div>
<div class="loginmain">
    <div class="login-title">
        <span>登录</span>
    </div>

    <form action="#" method="post">
        <div class="login-con">
            <div class="login-team">
                <div class="icon">
                    <img src="image/user_icon_copy.png" alt="">
                </div>
                <input type="text" name="teamname" id="teamname" placeholder="战队名" autocomplete="off">
            </div>
            <div class="login-user">
                <div class="icon">
                    <img src="image/user_icon_copy.png" alt="">
                </div>
                <input type="text" name="username" id="username" placeholder="用户名" autocomplete="off">
            </div>
            <div class="login-pwd">
                <div class="icon">
                    <img src="image/lock_icon_copy.png" alt="">
                </div>
                <input type="password" name="password" id="password" placeholder="密码" autocomplete="off" value="">
            </div>
            <div class="login-btn">
		<input type="button" onclick="login()" value="登录">
            </div>
        </div>
    </form>

</div>
<script>
	  //获取url参数
    function getUrlParam(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
        var r = window.location.search.substr(1).match(reg);  //匹配目标参数
        if (r != null) return unescape(r[2]); return null; //返回参数值
    }
    var data=getUrlParam('result');
    if(data != null){
                    if (data == "exit"){
                        Qmsg["success"]("已退出登入");
                    }
                    if (data == "nologin"){
                        Qmsg["warning"]("请先登入");
                    }
                    if (data == "nostart"){
                        Qmsg["warning"]("比赛未开始");
                    }
    }

    $(function(){
    	if(document.body.clientWidth<=1600){
	$('.loginmain').css("transform","scale(0.80,0.80)");
//	$('.one_title').css("transform","scale(0.75,0.75)");
	}
    });
    function login() {
        $(function () {
            var password = $("#password").val();
            var username = $("#username").val();
            var teamname = $("#teamname").val();
            $.ajax({
                type: 'POST',
                url: "login_judge.php",
                data:{'username':username,'password':password,'teamname':teamname},
                contentType: "application/x-www-form-urlencoded",
                success: function (data) {
                    if (data == "success"){
                         Qmsg["success"]("登入成功");
                         setTimeout(function(){
								window.location.href="index.php";
						 },1000);
                    }
                    if (data == "error"){
                         Qmsg["error"]("登入失败");
                    }
                }
            });
        })
    }

</script>
</body>
</html>

<script src="js/jquery.min.js"></script>
<script src="js/ban.js"></script>


