<?php
error_reporting(0);
include("check_login.php");
include("assembl.php");
include("config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>测试平台</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/admin_panel.css">
    <link rel="stylesheet" href="css/admin_match.css">
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
        <a class="nav-link active" id="v-pills-profile-tab" data-toggle="pill" href="#" role="tab"  aria-selected="false" onclick="window.location.href='admin_match.php'">题目管理</a>
        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#" role="tab"  aria-selected="false" onclick="window.location.href='admin_file.php'">附件管理</a>
        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#" role="tab"  aria-selected="false" onclick="window.location.href='admin_Notice.php'">公告管理</a>
        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#" role="tab"  aria-selected="false" onclick="window.location.href='admin_SetMatch.php'">比赛管理</a>
        <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab"  aria-selected="false" onclick="window.location.href='exit_login.php'">退出登入</a>
    </div>
</div>
<div class="loginmain  loginmain-box">
    <h2 id="title">题目管理面板</h2>
    <hr style="background-color: white">
    <div class="accordion" id="accordionExample">
<?php
foreach($subjects as $key=>$value) {
    echo ' <div class="card">
            <div class="card-header" id="heading' . $key . '">
                <h2 class="mb-0">
                    <button class="btn btn-link subject_name" type="button" data-toggle="collapse" data-target="#collapse' . $key . '" aria-expanded="true" aria-controls="collapse' . $key . '">
                        '.$value['subject_type'].' - '.$value['subject_name'].'
                    </button>
                </h2>
                <button type="button" class="btn btn-danger subject_del" onclick="subjectdel(\''.$value['subject_name'].'\');">删除</button>';

                if($value['subject_public']==true){
                	echo '
                	<button type="button" class="btn btn-primary subject_del" onclick="window.location.href=\'assembl.php?action=subject_public&subject='.$value['subject_name'].'&public=false\'">隐藏</button>';
				}else{
                	echo '
                	<button type="button" class="btn btn-success subject_del" onclick="window.location.href=\'assembl.php?action=subject_public&subject='.$value['subject_name'].'&public=true\'">公开</button>';	
				}
                echo
                '
            </div>
            <form action="assembl.php?action=subjectmodify" method="POST">
            <div id="collapse' . $key . '" class="collapse collapsed" aria-labelledby="heading' . $key . '" data-parent="#accordionExample">
                <br>
                <label class="radio-inline" style="color: #17a2b8;margin-left:20px">题目类型:&nbsp;'.$value["subject_type"].'</label>
                <br>
                <div class="input-group mb-3" style="width: 300px">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">题目名称</span>
                    </div>
                    <input type="text"  name="name"  value='.$value['subject_name'].' readonly="readonly" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                </div>
                <br><br><br>
                <div class="input-group mb-3" style="width: 200px">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">题目分值</span>
                    </div>
                    <input type="text" name="score" value='.$value['subject_score'].'  class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                </div>
                <br><br><br>
                <div class="input-group mb-3" style="width: 400px">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">题目答案</span>
                    </div>
                    <input type="text" name="flag" value='.$value['subject_flag'].'  class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                </div>
                <br><br><br>
                <div class="input-group mb-3" style="width: 400px">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">题目场景</span>
                    </div>
                    <input type="text" name="ip" value='.$value['subject_ip'].' class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                </div>
                <br><br><br>
                <div class="input-group mb-3" style="width: 400px">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">附件地址</span>
                    </div>
                    <input type="text" name="filelink" value='.$value['subject_file'].'  class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                </div>
                <br><br><br>
                <div class="input-group mb-3" style="width: 200px">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">创建时间</span>
                    </div>
                    <input type="text" value='.$value['subject_date'].' disabled="disabled" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                </div>
                <br><br><br>
                <div class="input-group" style="width: 400px;height: 200px">
                    <div class="input-group-prepend">
                        <span class="input-group-text">题目描述</span>
                    </div>
                    <textarea class="form-control" name="info" aria-label="With textarea">'.$value['subject_de'].'</textarea>
                </div>
                <br><br><br><br><br><br><br><br><br><br>
                <div class="input-group" style="width: 400px;height: 200px">
                    <div class="input-group-prepend">
                        <span class="input-group-text">题目提示</span>
                    </div>
                    <textarea name="tips" class="form-control" aria-label="With textarea">'.$value['subject_tips'].'</textarea>
                </div>
                <br><br><br><br><br><br><br><br><br><br>
                <input class="info btn btn-primary subject_sub" type="submit"  value="保存修改" style=""/>
                <br><br>
                </form>
            </div>
        </div>';
}
?>

        <div class="card">
            <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        添加题目
                    </button>
                </h2>
            </div>
            <form action="assembl.php?action=subjectadd" method="POST">
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <br>
                <label class="radio-inline" style="margin-left: 28px"><input type="radio" name="optradio" value="Web">Web</label>&nbsp;&nbsp;
                <label class="radio-inline"><input type="radio" name="optradio" value="Misc">Misc</label>&nbsp;&nbsp;
                <label class="radio-inline"><input type="radio" name="optradio" value="Crypto">Crypto</label>&nbsp;&nbsp;
                <label class="radio-inline"><input type="radio" name="optradio" value="Pwn">Pwn</label>&nbsp;&nbsp;
                <label class="radio-inline"><input type="radio" name="optradio" value="Reverse">Reverse</label>&nbsp;&nbsp;
                <br>
                <div class="input-group mb-3" style="width: 300px">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">题目名称</span>
                    </div>
                    <input type="text"  name="name" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                </div>
                <br><br><br>
                <div class="input-group mb-3" style="width: 200px">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">题目分值</span>
                    </div>
                    <input type="text" name="score" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                </div>
                <br><br><br>
                <div class="input-group mb-3" style="width: 400px">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">题目答案</span>
                    </div>
                    <input type="text" name="flag"   class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                </div>
                <br><br><br>
                <div class="input-group mb-3" style="width: 400px">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">题目场景</span>
                    </div>
                    <input type="text" name="ip" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                </div>
                <br><br><br>
                <div class="input-group mb-3" style="width: 400px">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">附件地址</span>
                    </div>
                    <input type="text" name="filelink" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                </div>
                <br><br><br>
                <div class="input-group mb-3" style="width: 200px">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">创建时间</span>
                    </div>
                    <input type="text"  value="当前时间" disabled="disabled" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                </div>
                <br><br><br>
                <div class="input-group" style="width: 400px;height: 200px">
                    <div class="input-group-prepend">
                        <span class="input-group-text">题目描述</span>
                    </div>
                    <textarea name="info" class="form-control" aria-label="With textarea"></textarea>
                </div>
                <br><br><br><br><br><br><br><br><br><br>
                <div class="input-group" style="width: 400px;height: 200px">
                    <div class="input-group-prepend">
                        <span class="input-group-text">题目提示</span>
                    </div>
                    <textarea name="tips" class="form-control" aria-label="With textarea"></textarea>
                </div>
                <br><br><br><br><br><br><br><br><br><br>
                <input class="info btn btn-success subject_sub" type="submit"  value="保存添加" style=""/>
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
<script>
function subjectdel($obj){

	var x; 
	var r=confirm("是否确认删除");
	if (r==true){
		window.location.href='assembl.php?action=subjectdel&subject='+$obj;
	}
}
</script>
<script src="js/jquery.min.js"></script>
<!--<script src="js/ban.js"></script>-->
