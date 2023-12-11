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
    <title>BLEEM战队内部测试平台</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/index2.css">
    <link rel="stylesheet" href="css/results.css">
    <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="js/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="js/set.js"></script>
    <script src="js/jquery.min.js"></script>
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
     <a href="#" onclick="auto()" id="auto">开启自动轮播</a>
    <a href="index.php" class="exit_login">进入比赛平台</a>
    <p class="exit_login team_name">战队: <?=$_SESSION['TeamName'];?></p>
    <p class="exit_login user_name">用户: <?=$_SESSION['UserName'];?></p>
</div>

<!-- 解题情况主体区域 -->
<div class="problem match_problem">
    <div class="layers_1">
    <div class="container table-responsive-sm" id="container">
        <table class="table table-dark table-hover" id="tables">
            <br>
                        <br>
         <thead>
            <tr  class="rank">
                <th>排名</th>
                <th>战队名</th>
                <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;单位</th>
                <th>web</th>
                <th>misc</th>
                <th>Crypto</th>
                <th>PWN</th>
                <th>Reverse</th>
                <th>一血数量</th>
                <th>总分</th>
            </tr>
            </thead>
            <tbody id="tbody">
            </tbody>
        </table>
        <div id="but">
        <button  type="button"  onclick="last()" class="btn btn-primary"><</button>&nbsp;
        <button  type="button"  onclick="next()" class="btn btn-primary">></button>
    </div>
    </div>
    </div>

</div>

<script>
    $(function(){
        if(document.body.clientWidth<1820){
            $("#tables").css("margin-left","-120px");
            $("#but").css("margin-left","37%");
        }
        if($(window).width()<=1600){
            $("#tables").css("transform","scale(0.80,0.80)")
            $("#tables").css("margin","-40px -200px");
            $("#but").css("margin","30px 29%");
            $("#auto").css("margin-left","85%");
        }
    });

    $(window).resize(function () {
        window.location.href="";
    });



    //排行榜
    start();
    //请求参数
    var list = {};
    function start() {
        $(function () {
            //
            $.ajax({
                //请求方式
                type: "POST",
                //请求的媒体类型
                contentType: "application/json;charset=UTF-8",
                //请求地址
                url: "assembl.php?action=results",
                //请求成功
                success: function (result) {
                    $('#tbody').empty();
                    list = jQuery.parseJSON(result);
                    var new_list = [];
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
                    for (var i = 1; i < 15+1; i++) {
                        if(list.length - i<0){
                            break;
                        }
                        $('#tbody').append('<tr><th>'+i+'</th><th>'+list[list.length-i]["team"]+'</th><th>'+list[list.length-i]["company"]+'</th><th>'+list[list.length-i]["Web"]+'</th><th>'+list[list.length-i]["Misc"]+'</th><th>'+list[list.length-i]["Crypto"]+'</th><th>'+list[list.length-i]["Pwn"]+'</th><th>'+list[list.length-i]["Reverse"]+'</th><th>'+list[list.length-i]["one"]+'</th><th>'+list[list.length-i]["score"]+'</th></tr>');
                    }
                },
                //请求失败，包含具体的错误信息
                error: function (e) {
                    console.log(e.status);
                    console.log(e.responseText);
                }
            });
        });
        //setTimeout(start,10000);
    }



    //判断是否auto
    var auto_pd=false;
    var count=0;
    function next(){
        count += 1;
        if(count*15+1<list.length+1) {
            $('#tbody').empty();
            for (var i = count * 15 + 1; i <  count * 15 + 16; i++) {
                if(list.length - i<0){
                    break;
                }
                $('#tbody').append('<tr><th>' + i + '</th><th>' + list[list.length - i]["team"] + '</th><th>' + list[list.length - i]["company"] + '</th><th>' + list[list.length - i]["Web"] + '</th><th>' + list[list.length - i]["Misc"] + '</th><th>' + list[list.length - i]["Crypto"] + '</th><th>' + list[list.length - i]["Pwn"] + '</th><th>' + list[list.length - i]["Reverse"] + '</th><th>' + list[list.length - i]["one"] + '</th><th>' + list[list.length - i]["score"] + '</th></tr>');
            }

        }else{
            count-=1;
            //轮播结束重新请求
            if(auto_pd==true){
                count=-1;
                start();
            }
        }

    }

    function last(){
        count -= 1;
        if(count*15+1>=1) {
            $('#tbody').empty();
            for (var i = count * 15 + 1; i < count * 15 + 16; i++) {
                if(list.length - i<0){
                    break;
                }
                $('#tbody').append('<tr><th>' + i + '</th><th>' + list[list.length - i]["team"] + '</th><th>' + list[list.length - i]["company"] + '</th><th>' + list[list.length - i]["Web"] + '</th><th>' + list[list.length - i]["Misc"] + '</th><th>' + list[list.length - i]["Crypto"] + '</th><th>' + list[list.length - i]["Pwn"] + '</th><th>' + list[list.length - i]["Reverse"] + '</th><th>' + list[list.length - i]["one"] + '</th><th>' + list[list.length - i]["score"] + '</th></tr>');
            }
        }else{
            count += 1;
        }
    }

    //自动轮播
    var ref=0;
    function auto(){
        if(auto_pd==false){
            $("#auto").html("关闭自动轮播");
            auto_pd=true;
            ref=setInterval(next, 10000);
        }else{
            $("#auto").html("开启自动轮播");
            auto_pd=false;
            clearInterval(ref);
        }
    }


</script>
</body>
</html>

<script src="js/ban.js"></script>