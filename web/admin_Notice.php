<?php
error_reporting(0);
include("check_login.php");
include("config.php");
include("assembl.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>测试平台</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/admin_panel.css">
    <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="js/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
<canvas class="cavs" width="1575" height="1337"></canvas>
<div class="loginmain loginmain-nav">
    <div id="navs" class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a class="nav-link"  id="v-pills-home-tab" data-toggle="pill" role="tab" aria-selected="true" onclick="window.location.href='admin_panel.php'" style="color: #007aff">用户管理</a>
        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#" role="tab"  aria-selected="false" onclick="window.location.href='admin_match.php'">题目管理</a>
        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#" role="tab"  aria-selected="false" onclick="window.location.href='admin_file.php'">附件管理</a>
        <a class="nav-link active" id="v-pills-profile-tab" data-toggle="pill" href="#" role="tab"  aria-selected="false" onclick="window.location.href='admin_Notice.php'">公告管理</a>
        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#" role="tab"  aria-selected="false" onclick="window.location.href='admin_SetMatch.php'">比赛管理</a>
        <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab"  aria-selected="false" onclick="window.location.href='exit_login.php'">退出登入</a>
    </div>
</div>

<div class="loginmain  loginmain-box">
    <h2 id="title">公告管理面板</h2>
    <hr style="background-color: white">
	<div style="width: 100%;height: 100%;overflow:auto;">
    <?php
    foreach ($notices as $key=>$value){
        echo '
    <div class="accordion" id="accordion">
        <div class="card">
            <div class="card-header">
                <a class="card-link titles" data-toggle="collapse" href="#collapse'.$key.'">
                    '.$value['notice'].'
                </a>
                <button type="button" class="btn btn-danger btns" onclick="window.location.href=\'assembl.php?action=noticedel&notdel='.$value['notice'].'\'">删除</button>
            </div>
        </div>
    </div>';
    }
    ?>
    <div class="accordion" id="accordion">
        <div class="card">
            <div class="card-header">
                <a class="card-link titles" data-toggle="collapse" href="#collapseTwo">
                    添加公告信息
                </a>
            </div>
            <form action="assembl.php?action=noteadd" method="POST" enctype="multipart/form-data">
                <div id="collapseTwo" class="collapse" data-parent="#accordion">
                    <div class="card-body">
                        <div class="panel-body title-body" id="bodys">
                            <div class="input-group" style="width: 400px;height: 100px;margin-left: 0">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">公告内容</span>
                                </div>
                                <textarea class="form-control" rows="5" id="comment" name="notice"></textarea>
                            </div>
                        </div>
                    </div>
                    <br><br><br><br><br><br>
                    <button type="submit" class="btn btn-primary" style="margin-left: 20px">保存添加</button>
                    <br><br>
                </div>
            </form>
	</div>
</div>
    </div>
</div>
<script>
    $(function(){
        if(document.body.clientWidth<1820){
            $(".loginmain-box").css("transform","scale(0.80,0.80)");
        }
    });
</script>
</body>
</html>

<script src="js/jquery.min.js"></script>
<!--<script src="js/ban.js"></script>-->
