<?php
error_reporting(0);
//include("check_login.php");
include("config.php");
include("session.php");
include("assembl.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>实时战况</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/index2.css">
    <link rel="stylesheet" href="css/realtime.css">
    <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="js/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="js/set.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/ban.js"></script>
    <style>
        html,body{
            width: 100%;
            height: 100%;
            background: url("image/bg2.jpeg") no-repeat;
            background-size: 100% 100%;

        }
    </style>
</head>
<body>
<canvas class="cavs" width="1575" height="1337"></canvas>

<!-- 顶部导航栏 -->
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
    <a href="index.php" class="exit_login">进入比赛平台</a>
</div>

<!-- 中间板块图 -->
<div class="centens match_centens">
    <p id="p1">Misc</p>
    <p id="p2">Crypto</p>
    <p id="p3">Reverse</p>
    <p id="p4">Pwn</p>
    <p id="p5">Web</p>
</div>

<!-- 侧边积分排行榜 -->
<div class="integral_rank match_rank">
    <div class="tops">
        <p>积分排名</p>
    </div>
    <div class="names">
        <ul class="rank" id="rank">
        </ul>
    </div>
    <div class="more">
        <a href="results.php">查看更多>></a>
    </div>
</div>

<!-- 侧边栏解题动态 -->
<div class="Problem match_problem">
    <div class="tops">
        <p>解题动态</p>
    </div>
    <div class="main_content">
        <ul id="content" class="contents">
            <?php
            foreach ($submits as $key => $value) {
                echo '
                   <li>' . $value['sumbit_date'] . '<p id="span1" title='.$value['team'].'>' . $value['team'] . '</p><p id="span2">解出了</p><p id="span3">' . $value['subject'] . '</p></li>';
            }
            ?>
        </ul>
    </div>
</div>
<script>
    $(function(){
        if(document.body.clientWidth<1820){
            $(".match_centens").css("transform","scale(0.85,0.85)");
            $(".match_rank").css("transform","scale(0.85,0.85)");
            $(".match_problem").css("transform","scale(0.85,0.85)");
            $(".match_centens").css("margin","-20px 270px");
            $(".match_rank").css("margin","-780px 60px");
            $(".match_problem").css("margin","-750px 1200px");
        }
    });

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
                    //var new_list = [];
                    //console.log(list);
                    //var len = list.length;
                    for (var i = 0; i < list.length - 1; i++) {
                        for (var a = 0; a < list.length - 1 - i; a++) {
                            if (list[a]["score"] > list[a + 1]["score"]) {
                                var temp = list[a];
                                list[a] = list[a + 1];
                                list[a + 1] = temp;
                            } else {
                                if (list[a]["score"] == list[a + 1]["score"]) {
                                    if (list[a]["date"] < list[a + 1]["date"]) {
                                        var temp = list[a];
                                        list[a] = list[a + 1];
                                        list[a + 1] = temp;
                                    }
                                }
                            }
                        }
                    }

                    for (var i = 1; i < 21; i++) {
                        if (i == 1) {
                            $('#rank').append('<li><span style="color: #ffb415;font-weight: bold;font-size: 30px">' + i + '</span><z>' + list[list.length - i]['username'] + '</z>&nbsp;&nbsp;<x>' + list[list.length - i]['score'] +'分'+'</x></li>');
                        } else if (i == 2) {
                            $('#rank').append('<li><span style="color: #ded7d7;font-weight: bold;font-size: 25px">' + i + '</span><z>' + list[list.length - i]['username'] + '</z>&nbsp;&nbsp;<x>' + list[list.length - i]['score'] +'分'+'</x></li>');

                        } else if (i == 3) {
                            $('#rank').append('<li><span style="color: #bd7919;font-weight: bold;font-size: 20px">' + i + '</span><z>' + list[list.length - i]['username'] + '</z>&nbsp;&nbsp;<x>' + list[list.length - i]['score'] +'分'+'</x></li>');
                        } else {
                            $('#rank').append('<li><span>' + i + '</span><z>' + list[list.length - i]['username'] + '</z>&nbsp;&nbsp;<x>' + list[list.length - i]['score'] +'分'+'</x></li>');
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
        setTimeout(start,26000);
    }

    function noticeUp(obj,top,time) {
        $(obj).animate({
            marginTop: top
        }, time, function () {
            $(this).css({marginTop:"0"}).find(":first").appendTo(this);
        })
    }
    $(function () {
        setInterval("noticeUp('#rank','-60px',1000)", 2000);
    });

</script>
</body>
</html>