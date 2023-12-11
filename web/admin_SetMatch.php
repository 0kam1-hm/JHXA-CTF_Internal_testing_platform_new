<?php
error_reporting(0);
include("check_login.php");
include("config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>测试平台</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/admin_panel.css">
    <link rel="stylesheet" href="css/admin_file.css">
    <link rel="stylesheet" href="css/admin_match.css">
    <link rel="stylesheet" href="css/admin_SetMatch.css">
    <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="js/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
<canvas class="cavs" width="1575" height="1337"></canvas>
<div class="loginmain loginmain-nav">
    <div id="navs" class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a class="nav-link" style="color: #007aff" id="v-pills-home-tab" data-toggle="pill" role="tab" aria-selected="true" onclick="window.location.href='admin_panel.php'">用户管理</a>
        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#" role="tab"  aria-selected="false" onclick="window.location.href='admin_match.php'">题目管理</a>
        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#" role="tab"  aria-selected="false" onclick="window.location.href='admin_file.php'">附件管理</a>
        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#" role="tab"  aria-selected="false" onclick="window.location.href='admin_Notice.php'">公告管理</a>
        <a class="nav-link active" id="v-pills-profile-tab" data-toggle="pill" href="#" role="tab"  aria-selected="false" onclick="window.location.href='admin_SetMatch.php'">比赛管理</a>
        <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab"  aria-selected="false" onclick="window.location.href='exit_login.php'">退出登入</a>
    </div>
</div>

<div class="loginmain  loginmain-box">
    <h2 id="title">比赛管理面板</h2>
    <hr style="background-color: white">
    <div class="accordion" id="accordionExample">
        <div class="card">
            <form action="assembl.php?action=subjecttitle" method="post">
                <div class="card-header" id="headingLast" >
                    <div style="height: 40px"></div>
                    <div id="match_title">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">竞赛标题</span>
                            </div>
                            <?php
                            if(file_exists("data/title.dat")) {
                                $title_name = unserialize(file_get_contents("data/title.dat"));
                                echo '<input type="text" name="name" id="sub_title" value="' . $title_name["title"] . '" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">';
                            }else{
                                echo '<input type="text" name="name" id="sub_title" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">';
                            }
                            ?>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-success subject_del title_mod" value="保存">
                </div>
            </form>
        </div>
        <div class="card">
            <form action="assembl.php?action=matchtime" method="post">
                <div class="card-header" id="headingLast">
                    <div style="height: 40px"></div>
                    <div class="match_time_start">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">开始时间</span>
                            </div>
                            <?php
                            if(file_exists("data/match_time.dat")) {
                                $time = unserialize(file_get_contents("data/match_time.dat"));
                                echo '<input type="text" name="start"  value="'.$time["start"].'" class="form-control"  placeholder="2022-01-09 08:00" aria-label="Default" aria-describedby="inputGroup-sizing-default">';
                            }else{
                                echo '<input type="text" name="start"  class="form-control"  placeholder="2022-01-09 08:00" aria-label="Default" aria-describedby="inputGroup-sizing-default">
';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="match_time_close">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">结束时间</span>
                            </div>
                            <?php
                            if(file_exists("data/match_time.dat")) {
                                $time = unserialize(file_get_contents("data/match_time.dat"));
                                echo '<input type="text" name="close"  value="'.$time["close"].'" class="form-control"  placeholder="2022-01-09 08:00" aria-label="Default" aria-describedby="inputGroup-sizing-default">';
                            }else{
                                echo '<input type="text" name="close"  class="form-control"  placeholder="2022-01-09 08:00" aria-label="Default" aria-describedby="inputGroup-sizing-default">
';
                            }
                            ?>
                       </div>
                    </div>
                    <input type="submit" class="btn btn-success subject_del title_mod" value="保存">
                </div>
            </form>
        </div>

<div class="card">
            <form action="assembl.php?action=subjectone" method="post">
                <div class="card-header" id="headingLast" >
                    <div style="height: 40px"></div>
                    <div id="match_title">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">一血加成分</span>
                            </div>
                            <?php
                            if(file_exists("data/one.dat")) {
                                $subject_one = unserialize(file_get_contents("data/one.dat"));
                                echo '<input type="text" name="one_score" id="sub_title" value="' . $subject_one["one_score"] . '" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">';
                            }else{
                                echo '<input type="text" name="name" id="sub_title" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">';
                            }
                            ?>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-success subject_del title_mod" value="保存">
                </div>
            </form>
        </div>
        
        <div class="card">
            <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        比赛数据管理
                    </button>
                </h2>
            </div>
            <form action="assembl.php?action=delete_data" method="POST">
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <label class="form-check-label Option_match" style="margin-left: 43px">
                            <input type="checkbox" class="form-check-input" name="subject">清空题目
                        </label>
                        <label class="form-check-label Option_match">
                            <input type="checkbox" class="form-check-input" name="score">清空分数
                        </label>
                        <label class="form-check-label Option_match">
                            <input type="checkbox" class="form-check-input" name="team">清空战队
                        </label>
                        <label class="form-check-label Option_match">
                            <input type="checkbox" class="form-check-input" name="notice">清空公告
                        </label>
                        <label class="form-check-label Option_match">
                            <input type="checkbox" class="form-check-input" name="file">清空附件
                        </label>
                    <br><br>
                    <input class="info btn btn-danger subject_sub" type="submit"  value="执行"/>
                    <br><br>
                </div>
            </form>
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
