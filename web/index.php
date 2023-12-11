<?php
session_start();
error_reporting(0);
//include("check_login.php");
include("session.php");
include("config.php");
include("assembl.php");

$conn = new mysqli($servername,$db_username,$db_password,$dbname);
if($conn->connect_error){
    die("数据库连接失败:".$conn->connect_error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>江环信安CTF内部测试平台</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="js/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/index2.css">
    <script src="js/set.js"></script>
        <link rel="stylesheet" href="./css/message.css">
     <script src="./js/message.min.js"></script>
    <style>
        html,body{
            width: 100%;
            height: 100%;
            background: url("image/bg2.jpeg") no-repeat;
            background-size: 100% 100%;
            overflow: hidden;

        }
    </style>
</head>
<body>
<canvas class="cavs" width="1575" height="1337"></canvas>
<?php
#判断比赛是否开始
if(file_exists("data/match_time.dat")) {
    $time = unserialize(file_get_contents("data/match_time.dat"));
    if(strtotime($time["start"].":00")>time()){
        die("<script>window.location.href=\"login.php?result=nostart\";</script>");
    }
}
?>
<div id="top">
    <?php
    #取得标题
    if(file_exists("data/title.dat")) {
        $title_name = unserialize(file_get_contents("data/title.dat"));
        echo "<h1>" . $title_name["title"] . "</h1>";
    }else{
        echo "<h1>测试平台</h1>";
    }
    ?>
<!--     <a href="realtime.php" id="realtime">实时战况</a> -->
    <a href="results.php" id="resuls">成绩榜单</a>
    <a href="exit_login.php" class="exit_login">退出登入</a>
    <p class="exit_login team_name">战队: <?=$_SESSION['TeamName'];?></p>
    <p class="exit_login user_name">用户: <?=$_SESSION['UserName'];?></p>
</div>
<div class="times match_times">
    <h3 id="time">距离比赛结束 00:00:00</h3>
</div>

<!-- 公告区域 -->
<div class="peripheral match_peripheral" id="peripheral">
    <div class="content" id="content">
        <a href="javascript:void(0)" onclick="Infor()"><img src="image/horn.png" alt="" /></a>
    </div>
    <div class="hiddens" id="hiddens">
        <ul id="notice_one">
            <?php
            foreach ($notices as $key=> $value) {
                echo'<li>'.$value['notice'].'</li >';
            }
            ?>
        </ul >
    </div>
</div>
<div class="Informations match_Informations" id="Informations">
    <a href="javascript:void(0)" onclick="hiden()">×</a>
    <div class="layers" id="notice_two">
        <?php
        foreach ($notices as $key=> $value){
            echo'
        <ul>
            <li>&nbsp;&nbsp;'.$value['notice'].'</li>
        </ul>';
        }
        ?>
    </div>
</div>

<!-- 公共弹窗 -->
<div class="dialogs alert alert-success" role="alert" style="z-index: 1003;margin-top: 360px" id="dialogs">
    flag正确!
</div>

<div class="loginmain match_subject">
    <h2 id="title">竞赛题目</h2>
    <div class="tops" id="tops">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation"><a class="nav-link active" id="pills-home-tab" data-toggle="pill" role="tab" aria-controls="pills-home" aria-selected="true" href="#" onclick="window.location.href='index.php'">全部题目</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" id="pills-profile-tab" data-toggle="pill" role="tab" aria-controls="pills-profile" aria-selected="false" href="javascript:void(0)" onclick="web_type()">Web</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" id="pills-profile-tab" data-toggle="pill" role="tab" aria-controls="pills-profile" aria-selected="false" href="javascript:void(0)" onclick="misc_type()">Misc</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" id="pills-profile-tab" data-toggle="pill" role="tab" aria-controls="pills-profile" aria-selected="false" href="javascript:void(0)" onclick="crypto_type()">Crypto</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" id="pills-profile-tab" data-toggle="pill" role="tab" aria-controls="pills-profile" aria-selected="false" href="javascript:void(0)" onclick="pwn_type()">PWN</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" id="pills-profile-tab" data-toggle="pill" role="tab" aria-controls="pills-profile" aria-selected="false" href="javascript:void(0)" onclick="reverse_type()">Reverse</a></li>
        </ul>
    </div>
    <hr style="background-color: white">
    <div class="accordion" id="accordionExample">
    <?php
        #查询提交flag记录
    $submit_sql = mysqli_query($conn, 'select * from submit_info;');
    $submits = [];
    while ($ro = mysqli_fetch_assoc($submit_sql)) {
        $submits[] = $ro;
    }
    mysqli_free_result($subject_sql); //释放结果集


    foreach($subjects as $key=>$value) {
        // var_dump( $_SESSION['TeamName']);
        // var_dump($value['subject_name']);
        // var_dump($submits[$key]['subject']);
        // var_dump($submits[$key]['team']);
        if ($value['subject_public'] == true) {
        $judeg=false;
        for($i=0;$i<count($submits);$i++){
            if($submits[$i]['team']== $_SESSION['TeamName'] && $submits[$i]['subject']==$value['subject_name']){
            echo ' <div class="card" id="card">
                   <div class="ribbon" id="ribbon" style="display: block;">
                       <span>已解决</span>
                   </div>';
                    $judeg=true;
            }
        }
        if($judeg==false){
             echo ' <div class="card" id="card">
                   <div class="ribbon" id="ribbon" style="display: none;">
                       <span>已解决</span>
                   </div>';
               }
            echo '
            <div class="card-header" id="heading' . $key . '">
                <h2 class="mb-0">
                    <button style="font-size: 20px;color: white" class="btn btn-link subject_name" type="button" data-toggle="collapse" data-target="#collapse' . $key . '" aria-expanded="true" aria-controls="collapse' . $key . '">
                        ' . $value['subject_name'] . '
                    </button>
                    <n style="margin-right: 30px">score: ' . $value['subject_score'] . '</n>
                </h2>
          </div>
            <div id="collapse' . $key . '" class="collapse collapsed" aria-labelledby="heading' . $key . '" data-parent="#accordionExample">
            <br>
            <!--<h4>题目名称: ' . $value['subject_name'] . '</h4>-->
            <h4>题目分值: ' . $value['subject_score'] . '</h4>';
            if (!preg_match("/^无$/", $value['subject_ip'])) {
                echo '<h4>题目场景: ' . $value['subject_ip'] . '</h4>';
            }
            if (!preg_match("/^无$/", $value['subject_file'])) {
                echo '<h4>题目附件: ' ;if($value['subject_file']!="#" ) {echo '<a href="' . $value['subject_file'] . '">点击下载</a>';};echo '</h4>';
            }
            if (!preg_match("/^无$/", $value['subject_de'])) {
                echo '<h4>题目描述: ' . $value['subject_de'] . '</h4>';
            }
            if (!preg_match("/^无$/", $value['subject_tips'])) {
                echo '<h4 id="tips_info">题目提示: <a style="color: red">' . $value['subject_tips'] . '</a></h4>';
            }
            echo '
            <br>
                <form action="assembl.php?action=putflag" method="post">
           <div class="input-group mb-3 container" id="test1" style="width: 500px;" >
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">flag</span>
                </div>
                <input type="text" name="flag" id="flag" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" autocomplete="off">
                <input type="hidden" name="subject_name" id="subject_name" value="' . $value['subject_name'] . '">
                <input type="hidden" name="teamnames" id="teamnames" value="'.$_SESSION['TeamName'].'">
            </div>
            <div style="width: 100px;" class="container">
            <input class="info btn btn-primary" type="submit" name="submit" value="提交" style=""/>
            </div>
                </form>
             <br>
            </div>
        </div>';
    }
    }
    ?>
    </div>
</div>
<div class="loginmain match_rank">
    <h2 id="title">排行榜</h2>
    <hr style="background-color: white">
    <ul id="rank">
    </ul>
</div>
<!-- 查看全部公告局部变暗 -->
<div id="over"></div>
<script>
    function tips_fun() {
        $("#tips_back").css("display","none");
    }
    tips_fun();

    //获取url参数
    function getUrlParam(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
        var r = window.location.search.substr(1).match(reg);  //匹配目标参数
        if (r != null) return unescape(r[2]); return null; //返回参数值
    }
    var data=getUrlParam('result');
    if(data != null){
                    if (data == "success"){
                         Qmsg["success"]("flag正确");
                    }
                    if (data == "error"){
                         Qmsg["error"]("flag错误");
                    }if (data == "repeat"){
                        Qmsg["warning"]("重复提交");
                    }if (data == "over"){
                        Qmsg["warning"]("比赛已结束");
                    }if (data == "exit"){
                        Qmsg["success"]("已退出登入");
                    }
    }

    $(window).resize(function () {
        window.location.href="index.php";
    });

        $(function(){
        if(document.body.clientWidth<1820){
            $(".match_subject").css("transform","scale(0.75,0.75)");
            $(".match_rank").css("transform","scale(0.75,0.75)");
            $(".match_peripheral").css("transform","scale(0.75,0.75)");
            $(".match_Informations").css("transform","scale(1,1)");
            $(".match_times").css("transform","scale(0.75,0.75");
            $(".match_subject").css("margin","30px 170px");
            $(".match_rank").css("margin","30px 1120px");
            $(".match_peripheral").css("margin","-0px 170px");
            $(".match_Informations").css("margin","-0px 170px");
            $(".match_times").css("margin","-0px 1112px")
        }
            if($(window).width()<=1600){
                $(".match_subject").css("margin","50px 60px");
                $(".match_rank").css("margin","50px 1010px");
                $(".match_peripheral").css("margin","30px 60px");
                $(".match_Informations").css("margin","30px 60px");
                $(".match_times").css("margin","30px 992px");
                $("#resuls").css("margin-left","88%");
	    }
	   if(document.body.clientWidth>1800){
            $(".match_subject").css("transform","scale(0.93,0.93)");
            $(".match_rank").css("transform","scale(0.93,0.93)");
            $(".match_peripheral").css("transform","scale(0.93,0.93)");
            $(".match_Informations").css("transform","scale(1,1)");
            $(".match_times").css("transform","scale(0.90,0.90");
            $(".match_subject").css("margin","150px 200px");
            $(".match_rank").css("margin","150px 1280px");
            $(".match_peripheral").css("margin","50px 200px");
            $(".match_Informations").css("margin","50px 200px");
            $(".match_times").css("margin","50px 1270px")
	   }

	   if(document.body.clientWidth>1700&&document.body.clientWidth<1800){
            $(".match_subject").css("transform","scale(0.85,0.85)");
            $(".match_rank").css("transform","scale(0.85,0.85)");
            $(".match_peripheral").css("transform","scale(0.85,0.85)");
            $(".match_Informations").css("transform","scale(1,1)");
            $(".match_times").css("transform","scale(0.82,0.82");
            $(".match_subject").css("margin","100px 170px");
            $(".match_rank").css("margin","100px 1190px");
            $(".match_peripheral").css("margin","40px 170px");
            $(".match_Informations").css("margin","40px 170px");
            $(".match_times").css("margin","40px 1180px")
        }



    });

    //公告栏
    notice_update();
    function notice_update() {
        $(function () {
            //请求参数
            var list = {};
            //
            $.ajax({
                //请求方式
                type: "POST",
                //请求的媒体类型
                contentType: "application/json;charset=UTF-8",
                //请求地址
                url: "assembl.php?action=notices",
                //请求成功
                success: function (result) {
                    var list = jQuery.parseJSON(result);
                    $("#notice_one").empty();
                    $("#notice_two").empty();
                    for(var i=1;i<list.length+1;i++){
                       $("#notice_one").append('<li>'+list[list.length-i]["notice"]+'</li>');
                       $("#notice_two").append('<ul><li>'+list[list.length-i]["notice"]+'</li></ul>');
                    }
                },
                //请求失败，包含具体的错误信息
                error: function (e) {
                    console.log(e.status);
                    console.log(e.responseText);
                }
            });
        });
        setTimeout(notice_update,10000);
    }

    

    //排行榜
    start();
    function start() {
        $(function () {
            //请求参数
            var list = {};
            //
            $.ajax({
                //请求方式
                type: "POST",
                //请求的媒体类型
                contentType: "application/json;charset=UTF-8",
                //请求地址
                url: "assembl.php?action=getrank",
                //请求成功
                success: function (result) {
                    $("#rank").empty();
                    var list = jQuery.parseJSON(result);
                    var new_list = [];
                    //console.log(list);
                    var len = list.length;
                    for (var i = 0; i < list.length - 1; i++) {
                        for (var a = 0; a < list.length - 1 - i; a++) {
                            if (parseInt(list[a]["score"]) > parseInt(list[a + 1]["score"])) {
                                var temp = list[a];
                                list[a] = list[a + 1];
                                list[a + 1] = temp;
                            } else {
                                if (parseInt(list[a]["score"]) == parseInt(list[a + 1]["score"])) {
                                    if (parseInt(list[a]["sumbit_date"]) < parseInt(list[a + 1]["sumbit_date"])) {
                                        var temp = list[a];
                                        list[a] = list[a + 1];
                                        list[a + 1] = temp;
                                    }
                                }
                            }
                        }
                    }
                    for (var i = 1; i < 11; i++) {
                        if(list.length - i<0){
                            break;
                        }
                        if (i == 1) {
                            $('#rank').append('<li><span style="color: #ffb415;font-weight: bold;font-size: 30px">' + i + '</span><z>' + list[list.length - i]['team'] + '</z>&nbsp;&nbsp;<x>score: ' + list[list.length - i]['score'] + '</x></li>');
                        } else if (i == 2) {
                            $('#rank').append('<li><span style="color: #ded7d7;font-weight: bold;font-size: 25px">' + i + '</span><z>' + list[list.length - i]['team'] + '</z>&nbsp;&nbsp;<x>score: ' + list[list.length - i]['score'] + '</x></li>');

                        } else if (i == 3) {
                            $('#rank').append('<li><span style="color: #bd7919;font-weight: bold;font-size: 20px">' + i + '</span><z>' + list[list.length - i]['team'] + '</z>&nbsp;&nbsp;<x>score: ' + list[list.length - i]['score'] + '</x></li>');
                        } else {
                            $('#rank').append('<li><span>' + i + '</span><z>' + list[list.length - i]['team'] + '</z>&nbsp;&nbsp;<x>score: ' + list[list.length - i]['score'] + '</x></li>');
                        }
                    }
                },
                //请求失败，包含具体的错误信息
                error: function (e) {
                    console.log(e.status);
                    console.log(e.responseText);
                }
            });
        });
        setTimeout(start,10000);
    }

<?php
    if(file_exists("data/match_time.dat")) {
        $time = unserialize(file_get_contents("data/match_time.dat"));
        echo 'var starttime = new Date("'.$time["close"].'");
    setInterval(function () {
        var nowtime = new Date();
        var time = starttime - nowtime;
        var day = parseInt(time / 1000 / 60 / 60 / 24);
        var hour = parseInt(time / 1000 / 60 / 60 % 24);
        var minute = parseInt(time / 1000 / 60 % 60);
        var seconds = parseInt(time / 1000 % 60);
        if((hour+day*24)<10){var h="0"+(hour+day*24)+":"}else{var h=(hour+day*24)+":"}
        if(minute<10){var m="0"+minute+":"}else{var m=minute+":"}
        if(seconds<10){var s="0"+seconds+" "}else{var s=seconds+" "}
        $("#time").html(h+ m + s );
        
        if((hour+day*24)<1 && minute<1 && seconds<1){$("#time").css("color","red");$("#time").html("比赛已结束");
        }else if(time/1000 <= 1800){
            document . getElementById("time") . innerHTML = "距离比赛结束还剩 " + h + m + s;
             $("#time") . css("color", "brown");
        }else{
            document . getElementById("time") . innerHTML = "距离比赛结束 " + h + m + s;
        }
    }, 1000);';
    }
    ?>

    //模块分类
    function web_type(){
                 $("#accordionExample").empty();
                 <?php
                 foreach ($subjects as $key=>$value) {
                     if ($value['subject_type'] == 'Web') {
                     if ($value['subject_public'] == true) {
                    echo '$("#accordionExample").append(\'';
                    $judeg=false;
                    for($i=0;$i<count($submits);$i++){
                        if($submits[$i]['team']== $_SESSION['TeamName'] && $submits[$i]['subject']==$value['subject_name']){
                            echo '<div class="card" id="card"><div class="ribbon"  style="display: block;" id="ribbon"><span>已解决</span></div>';
                             $judeg=true;
                    }
                 }
                    if($judeg==false){
                        echo '<div class="card" id="card"><div class="ribbon" id="ribbon"><span>已解决</span></div>';
                     }

                         echo '<div class="card-header" id="heading' . $key . '"><h2 class="mb-0"><button style="font-size: 20px;color: white" class="btn btn-link subject_name" type="button" data-toggle="collapse" data-target="#collapse' . $key . '" aria-expanded="true" aria-controls="collapse' . $key . '">' . $value['subject_name'] . '</button><n style="margin-right: 30px">score: ' . $value['subject_score'] . '</n></h2></div><div id="collapse' . $key . '" class="collapse collapsed" aria-labelledby="heading' . $key . '" data-parent="#accordionExample"><br><!--<h4>题目名称: ' . $value['subject_name'] . '</h4>--><h4>题目分值: ' . $value['subject_score'] . '</h4>';if (!preg_match("/^无$/", $value['subject_ip'])) {echo '<h4>题目场景: ' . $value['subject_ip'] . '</h4>';}if (!preg_match("/^无$/", $value['subject_file'])) {echo '<h4>题目附件: ' ;if($value['subject_file']!="#" ) {echo '<a href="' . $value['subject_file'] . '">点击下载</a>';};echo '</h4>';}if (!preg_match("/^无$/", $value['subject_de'])) {echo '<h4>题目描述: ' . $value['subject_de'] . '</h4>';}if (!preg_match("/^无$/", $value['subject_tips'])) {echo '<h4 id="tips_info">题目提示: <a style="color: red">' . $value['subject_tips'] . '</a></h4>';}echo '<br><form action="assembl.php?action=putflag" method="post"><div class="input-group mb-3 container" style="width: 500px;" ><div class="input-group-prepend"><span class="input-group-text" id="inputGroup-sizing-sm">flag</span></div><input type="text" name="flag" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm"><input type="hidden" name="subject_name" value="' . $value['subject_name'] . '"><input type="hidden" name="teamnames" value="'.$_SESSION['TeamName'].'"></div><div style="width: 100px;" class="container"><input class="info btn btn-primary" type="submit" name="submit" value="提交" style=""/></div><br></form></div></div>\');';
                     }
                 }
                 }
                 ?>
    }
    function misc_type(){
                    $("#accordionExample").empty();
                    <?php
                    foreach ($subjects as $key=>$value) {
                    if ($value['subject_type'] == 'Misc') {
                    if ($value['subject_public'] == true) {
                    echo '$("#accordionExample").append(\'';
                    $judeg=false;
                    for($i=0;$i<count($submits);$i++){
                        if($submits[$i]['team']== $_SESSION['TeamName'] && $submits[$i]['subject']==$value['subject_name']){
                            echo '<div class="card" id="card"><div class="ribbon"  style="display: block;" id="ribbon"><span>已解决</span></div>';
                             $judeg=true;
                    }
                 }
                    if($judeg==false){
                        echo '<div class="card" id="card"><div class="ribbon" id="ribbon"><span>已解决</span></div>';
                     }
                            echo '<div class="card-header" id="heading' . $key . '"><h2 class="mb-0"><button style="font-size: 20px;color: white" class="btn btn-link subject_name" type="button" data-toggle="collapse" data-target="#collapse' . $key . '" aria-expanded="true" aria-controls="collapse' . $key . '">' . $value['subject_name'] . '</button><n style="margin-right: 30px">score: ' . $value['subject_score'] . '</n></h2></div><div id="collapse' . $key . '" class="collapse collapsed" aria-labelledby="heading' . $key . '" data-parent="#accordionExample"><br><!--<h4>题目名称: ' . $value['subject_name'] . '</h4>--><h4>题目分值: ' . $value['subject_score'] . '</h4>';if (!preg_match("/^无$/", $value['subject_ip'])) {echo '<h4>题目场景: ' . $value['subject_ip'] . '</h4>';}if (!preg_match("/^无$/", $value['subject_file'])) {echo '<h4>题目附件: ' ;if($value['subject_file']!="#" ) {echo '<a href="' . $value['subject_file'] . '">点击下载</a>';};echo '</h4>';}if (!preg_match("/^无$/", $value['subject_de'])) {echo '<h4>题目描述: ' . $value['subject_de'] . '</h4>';}if (!preg_match("/^无$/", $value['subject_tips'])) {echo '<h4 id="tips_info">题目提示: <a style="color: red">' . $value['subject_tips'] . '</a></h4>';}echo '<br><form action="assembl.php?action=putflag" method="post"><div class="input-group mb-3 container" style="width: 500px;" ><div class="input-group-prepend"><span class="input-group-text" id="inputGroup-sizing-sm">flag</span></div><input type="text" name="flag" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm"><input type="hidden" name="subject_name" value="' . $value['subject_name'] . '"><input type="hidden" name="teamnames" value="'.$_SESSION['TeamName'].'"></div><div style="width: 100px;" class="container"><input class="info btn btn-primary" type="submit" name="submit" value="提交" style=""/></div><br></form></div></div>\');';
                     }
                 }
                 }
                 ?>
    }

    function crypto_type(){
              $("#accordionExample").empty();
                    <?php
                    foreach ($subjects as $key=>$value) {
                    if ($value['subject_type'] == 'Crypto') {
                    if ($value['subject_public'] == true) {
                    echo '$("#accordionExample").append(\'';
                    $judeg=false;
                    for($i=0;$i<count($submits);$i++){
                        if($submits[$i]['team']== $_SESSION['TeamName'] && $submits[$i]['subject']==$value['subject_name']){
                            echo '<div class="card" id="card"><div class="ribbon"  style="display: block;" id="ribbon"><span>已解决</span></div>';
                             $judeg=true;
                    }
                 }
                    if($judeg==false){
                        echo '<div class="card" id="card"><div class="ribbon" id="ribbon"><span>已解决</span></div>';
                     }
                            echo '<div class="card-header" id="heading' . $key . '"><h2 class="mb-0"><button style="font-size: 20px;color: white" class="btn btn-link subject_name" type="button" data-toggle="collapse" data-target="#collapse' . $key . '" aria-expanded="true" aria-controls="collapse' . $key . '">' . $value['subject_name'] . '</button><n style="margin-right: 30px">score: ' . $value['subject_score'] . '</n></h2></div><div id="collapse' . $key . '" class="collapse collapsed" aria-labelledby="heading' . $key . '" data-parent="#accordionExample"><br><!--<h4>题目名称: ' . $value['subject_name'] . '</h4>--><h4>题目分值: ' . $value['subject_score'] . '</h4>';if (!preg_match("/^无$/", $value['subject_ip'])) {echo '<h4>题目场景: ' . $value['subject_ip'] . '</h4>';}if (!preg_match("/^无$/", $value['subject_file'])) {echo '<h4>题目附件: ' ;if($value['subject_file']!="#" ) {echo '<a href="' . $value['subject_file'] . '">点击下载</a>';};echo '</h4>';}if (!preg_match("/^无$/", $value['subject_de'])) {echo '<h4>题目描述: ' . $value['subject_de'] . '</h4>';}if (!preg_match("/^无$/", $value['subject_tips'])) {echo '<h4 id="tips_info">题目提示: <a style="color: red">' . $value['subject_tips'] . '</a></h4>';}echo '<br><form action="assembl.php?action=putflag" method="post"><div class="input-group mb-3 container" style="width: 500px;" ><div class="input-group-prepend"><span class="input-group-text" id="inputGroup-sizing-sm">flag</span></div><input type="text" name="flag" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm"><input type="hidden" name="subject_name" value="' . $value['subject_name'] . '"><input type="hidden" name="teamnames" value="'.$_SESSION['TeamName'].'"></div><div style="width: 100px;" class="container"><input class="info btn btn-primary" type="submit" name="submit" value="提交" style=""/></div><br></form></div></div>\');';
                     }
                 }
                 }
                 ?>
    }

    function pwn_type(){
                    $("#accordionExample").empty();
                    <?php
                    foreach ($subjects as $key=>$value) {
                    if ($value['subject_type'] == 'Pwn') {
                    if ($value['subject_public'] == true) {

                    echo '$("#accordionExample").append(\'';
                    $judeg=false;
                    for($i=0;$i<count($submits);$i++){
                        if($submits[$i]['team']== $_SESSION['TeamName'] && $submits[$i]['subject']==$value['subject_name']){
                            echo '<div class="card" id="card"><div class="ribbon"  style="display: block;" id="ribbon"><span>已解决</span></div>';
                             $judeg=true;
                    }
                 }
                    if($judeg==false){
                        echo '<div class="card" id="card"><div class="ribbon" id="ribbon"><span>已解决</span></div>';
                     }
                            echo '<div class="card-header" id="heading' . $key . '"><h2 class="mb-0"><button style="font-size: 20px;color: white" class="btn btn-link subject_name" type="button" data-toggle="collapse" data-target="#collapse' . $key . '" aria-expanded="true" aria-controls="collapse' . $key . '">' . $value['subject_name'] . '</button><n style="margin-right: 30px">score: ' . $value['subject_score'] . '</n></h2></div><div id="collapse' . $key . '" class="collapse collapsed" aria-labelledby="heading' . $key . '" data-parent="#accordionExample"><br><!--<h4>题目名称: ' . $value['subject_name'] . '</h4>--><h4>题目分值: ' . $value['subject_score'] . '</h4>';if (!preg_match("/^无$/", $value['subject_ip'])) {echo '<h4>题目场景: ' . $value['subject_ip'] . '</h4>';}if (!preg_match("/^无$/", $value['subject_file'])) {echo '<h4>题目附件: ' ;if($value['subject_file']!="#" ) {echo '<a href="' . $value['subject_file'] . '">点击下载</a>';};echo '</h4>';}if (!preg_match("/^无$/", $value['subject_de'])) {echo '<h4>题目描述: ' . $value['subject_de'] . '</h4>';}if (!preg_match("/^无$/", $value['subject_tips'])) {echo '<h4 id="tips_info">题目提示: <a style="color: red">' . $value['subject_tips'] . '</a></h4>';}echo '<br><form action="assembl.php?action=putflag" method="post"><div class="input-group mb-3 container" style="width: 500px;" ><div class="input-group-prepend"><span class="input-group-text" id="inputGroup-sizing-sm">flag</span></div><input type="text" name="flag" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm"><input type="hidden" name="subject_name" value="' . $value['subject_name'] . '"><input type="hidden" name="teamnames" value="'.$_SESSION['TeamName'].'"></div><div style="width: 100px;" class="container"><input class="info btn btn-primary" type="submit" name="submit" value="提交" style=""/></div><br></form></div></div>\');';
                     }
                 }
                 }
                 ?>
    }

    function reverse_type(){
                    $("#accordionExample").empty();
                    <?php
                    foreach ($subjects as $key=>$value) {
                    if ($value['subject_type'] == 'Reverse') {
                    if ($value['subject_public'] == true) {
                    echo '$("#accordionExample").append(\'';
                    $judeg=false;
                    for($i=0;$i<count($submits);$i++){
                        if($submits[$i]['team']== $_SESSION['TeamName'] && $submits[$i]['subject']==$value['subject_name']){
                            echo '<div class="card" id="card"><div class="ribbon"  style="display: block;" id="ribbon"><span>已解决</span></div>';
                             $judeg=true;
                    }
                 }
                    if($judeg==false){
                        echo '<div class="card" id="card"><div class="ribbon" id="ribbon"><span>已解决</span></div>';
                     }
                            echo '<div class="card-header" id="heading' . $key . '"><h2 class="mb-0"><button style="font-size: 20px;color: white" class="btn btn-link subject_name" type="button" data-toggle="collapse" data-target="#collapse' . $key . '" aria-expanded="true" aria-controls="collapse' . $key . '">' . $value['subject_name'] . '</button><n style="margin-right: 30px">score: ' . $value['subject_score'] . '</n></h2></div><div id="collapse' . $key . '" class="collapse collapsed" aria-labelledby="heading' . $key . '" data-parent="#accordionExample"><br><!--<h4>题目名称: ' . $value['subject_name'] . '</h4>--><h4>题目分值: ' . $value['subject_score'] . '</h4>';if (!preg_match("/^无$/", $value['subject_ip'])) {echo '<h4>题目场景: ' . $value['subject_ip'] . '</h4>';}if (!preg_match("/^无$/", $value['subject_file'])) {echo '<h4>题目附件: ' ;if($value['subject_file']!="#" ) {echo '<a href="' . $value['subject_file'] . '">点击下载</a>';};echo '</h4>';}if (!preg_match("/^无$/", $value['subject_de'])) {echo '<h4>题目描述: ' . $value['subject_de'] . '</h4>';}if (!preg_match("/^无$/", $value['subject_tips'])) {echo '<h4 id="tips_info">题目提示: <a style="color: red">' . $value['subject_tips'] . '</a></h4>';}echo '<br><form action="assembl.php?action=putflag" method="post"><div class="input-group mb-3 container" style="width: 500px;" ><div class="input-group-prepend"><span class="input-group-text" id="inputGroup-sizing-sm">flag</span></div><input type="text" name="flag" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm"><input type="hidden" name="subject_name" value="' . $value['subject_name'] . '"><input type="hidden" name="teamnames" value="'.$_SESSION['TeamName'].'"></div><div style="width: 100px;" class="container"><input class="info btn btn-primary" type="submit" name="submit" value="提交" style=""/></div><br></form></div></div>\');';
                     }
                 }
                 }
                 ?>
    }

</script>
</body>
</html>

<script src="js/jquery.min.js"></script>
<script src="js/ban.js"></script>

