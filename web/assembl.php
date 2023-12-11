<?php
error_reporting(0);
session_start();
require('config.php');
$conn = new mysqli($servername,$db_username,$db_password,$dbname);

if($conn->connect_error){
    die("数据库连接失败:".$conn->connect_error);
}else {
    #查询用户所有字段的相应内容
    $user_sql = mysqli_query($conn, 'select * from platform_user');
    $users = [];
    while ($rows = mysqli_fetch_assoc($user_sql)) {
        $users[] = $rows;
    }
    mysqli_free_result($user_sql); //释放结果集

    #查询题目所有字段的相应内容
    $subject_sql = mysqli_query($conn, 'select * from subject_info');
    $subjects = [];
    while ($row = mysqli_fetch_assoc($subject_sql)) {
        $subjects[] = $row;
    }
    mysqli_free_result($subject_sql); //释放结果集

    #查询提交flag记录
    $submit_sql = mysqli_query($conn, 'select * from submit_info;');
    $submits = [];
    while ($ro = mysqli_fetch_assoc($submit_sql)) {
        $submits[] = $ro;
    }
    mysqli_free_result($subject_sql); //释放结果集

    #查询战队分数
    $scores_sql = mysqli_query($conn, 'select * from score_info;');
    $scores = [];
    while ($ro = mysqli_fetch_assoc($scores_sql)) {
        $scores[] = $ro;
    }
    mysqli_free_result($subject_sql); //释放结果集

    #查询公告记录
    $notices_sql = mysqli_query($conn, 'select * from notice_info;');
    $notices = [];
    while ($n = mysqli_fetch_assoc($notices_sql)) {
        $notices[] = $n;
    }
    mysqli_free_result($subject_sql); //释放结果集


    #查询公告记录
    if($_GET['action']=='notices') {
        $notices_sql = mysqli_query($conn, 'select * from notice_info;');
        $notices = [];
        while ($n = mysqli_fetch_assoc($notices_sql)) {
            $notices[] = $n;
        }
        mysqli_free_result($subject_sql); //释放结果集
        echo json_encode($notices);
    }
    #用户添加
    if($_GET['action']=='useradd') {
        include("check_login.php");

        if($_POST['username']=="" or $_POST['password']=="" or $_POST['remarks']=="" or $_POST['teams']==""){
            die("<script>alert('输入错误');window.location.href=\"admin_panel.php\";</script>");
        }
        foreach($users as $key=>$value){
            if($value["username"]==$_POST['remarks']){
                die("<script>alert('用户已经存在');window.location.href=\"admin_panel.php\";</script>");
            }
        }
          #判断该战队是否存在
         $pd = mysqli_query($conn, 'select * from platform_user where team_info="'.$_POST['teams'].'"');
         $s=[];
    	while ($row = mysqli_fetch_assoc($pd)) {
    		$s[]=$row;
    	}
    	mysqli_free_result($pd); //释放结果集
    	$c=count($s);
    	if($c<1){
            	$userscore_sql="insert into score_info values('".$_POST['teams']."','". time()."',0)";
         	    $conn->query($userscore_sql);
    	}

        $useradd_sql = "insert into platform_user (username,login_name,login_pass,team_info,user_date,company) values ('" . $_POST['remarks'] . "','" . $_POST['username'] . "','" . md5(trim($_POST['password'])) . "','" . $_POST['teams'] . "','" . date("Y-m-d", time()) . "','".$_POST['company']."')";
        if ($conn->query($useradd_sql) === TRUE) {
            die("<script>window.location.href=\"admin_panel.php\";</script>");
        }
    }
    #用户删除
    if($_GET['action']=='userdel') {
        include("check_login.php");

        $user=$_GET['login_name'];
        $team=$_GET['team'];
        foreach($users as $key=>$value){
            if($value['login_name']==$user){
                $deluser_sql = "delete from platform_user where login_name='".$value['login_name']."'";
                $delete = mysqli_query($conn,$deluser_sql);
                if($delete){
                	#判断该战队是否还存在其他用户
                	    $pd = mysqli_query($conn, 'select * from platform_user where team_info="'.$team.'"');
                	    $s=[];
    					while ($row = mysqli_fetch_assoc($pd)) {
    						$s[]=$row;
    					}
    					mysqli_free_result($pd); //释放结果集
    					$c=count($s);
    					if($c<1){
    						 $delteam_sql = "delete from score_info where team='".$team."'";
                             $delete = mysqli_query($conn,$delteam_sql);
    						 $delteam_sql = "delete from submit_info where team='".$team."'";
                             $delete = mysqli_query($conn,$delteam_sql);
    					}
                    die("<script>window.location.href=\"admin_panel.php\";</script>");
                }
            }
        }
    }
    #用户修改
    if($_GET['action']=='usermodify') {
        include("check_login.php");
        $user=$_POST['remarks'];
        foreach($users as $key=>$value){
            if($value['username']==$user){
                $users[$key]['login_name']=$_POST['username'];
                $users[$key]['login_pass']=md5(trim($_POST['password']));
                $users[$key]['team_info']=$_POST['teams'];
                $users[$key]['company']=$_POST['company'];
                $upuser_sql = "update platform_user set company='".$users[$key]['company']."',login_name='".$users[$key]['login_name']."',login_pass='".$users[$key]['login_pass']."' ,team_info='".$users[$key]['team_info']."' where username='$user'";
                $update = mysqli_query($conn,$upuser_sql);
                if ($update) {
                    die("<script>window.location.href=\"admin_panel.php\";</script>");
                }
            }
        }
    }

    #题目添加
    if($_GET['action']=='subjectadd') {
        include("check_login.php");
        if ($_POST['name'] == '') {
            die("<script>alert('输入错误');window.location.href=\"admin_match.php\";</script>");
        }
        $search = "select subject_name from subject_info where subject_name='".addslashes($_POST['name'])."'";
        $names = mysqli_query($conn,$search);
        if(mysqli_num_rows($names)>0) {
            die("<script>alert('题目已存在');window.location.href=\"admin_match.php\";</script>");
        }
        #题目添加
        $_POST['filelink']!="" ? :$_POST['filelink']="#";
        $_POST['name']!="" ? :$_POST['name']="#";
        $_POST['score']!="" ? :$_POST['score']="#";
        $_POST['flag']!="" ? :$_POST['flag']="#";
        $_POST['ip']!="" ? :$_POST['ip']="#";

        $sql = "insert into subject_info (subject_type,subject_name,subject_score,subject_flag,subject_ip,subject_de,subject_file,subject_tips,subject_date,subject_public) values ('" . addslashes($_POST['optradio']) . "','" . addslashes($_POST['name']) . "','" . $_POST['score'] . "','" . addslashes($_POST['flag']) . "','" . addslashes($_POST['ip']) . "','" . addslashes($_POST['info']) . "','" . addslashes($_POST['filelink']) . "','" . addslashes($_POST['tips']) . "','" . date("Y-m-d", time()) . "',true)";
        if ($conn->query($sql) === TRUE) {
            die("<script>window.location.href=\"admin_match.php\";</script>");
        }

    }

    #删除题目
    if($_GET['action']=='subjectdel') {
        include("check_login.php");
        $subject_name=$_GET['subject'];
        foreach($subjects as $key=>$value){
            if($value['subject_name']==$subject_name) {
                $deletesql = "delete from subject_info where subject_name='".$value['subject_name']."'";
                $delete = mysqli_query($conn,$deletesql);
                if($delete){
                    die("<script>window.location.href=\"admin_match.php\";</script>");
                }
            }
        }
    }

    #隐藏 or 公开题目
    if($_GET['action']=='subject_public') {
        include("check_login.php");
        $subject_name=$_GET['subject'];
        foreach($subjects as $key=>$value){
            if($value['subject_name']==$subject_name) {
                $publicsql = "update subject_info set subject_public=".$_GET['public']." where subject_name='".$value['subject_name']."'";
                $public = mysqli_query($conn,$publicsql);
                if($public){
                    die("<script>window.location.href=\"admin_match.php\";</script>");
                }
            }
        }
    }
    #修改题目内容
    if($_GET['action']=='subjectmodify') {
        include("check_login.php");
        $subject=$_POST['name'];
        foreach($subjects as $key=>$value){
            $subjects[$key]['subject_file']=$_POST['filelink'];
            $subjects[$key]['subject_de']=$_POST['info'];
            $subjects[$key]['subject_tips']=$_POST['tips'];
            $subjects[$key]['subject_ip']=$_POST['ip'];
            $subjects[$key]['subject_score']=$_POST['score'];
            $subjects[$key]['subject_flag']=$_POST['flag'];
            $updatesql = "update subject_info set subject_file='".$subjects[$key]['subject_file']."',subject_de='".$subjects[$key]['subject_de']."' ,subject_tips='".$subjects[$key]['subject_tips']."',subject_ip='".$subjects[$key]['subject_ip']."',subject_score='".$subjects[$key]['subject_score']."',subject_flag='".$subjects[$key]['subject_flag']."' where subject_name='$subject'";
            $update = mysqli_query($conn,$updatesql);
            if ($update) {
                die("<script>window.location.href=\"admin_match.php\";</script>");
            }
        }
    }

    #验证flag
    $action = $_GET['action'];
    if($action=='putflag') {
        include("session.php");
        #判断比赛是否结束
        if(file_exists("data/match_time.dat")) {
            $time = unserialize(file_get_contents("data/match_time.dat"));
            if(strtotime($time["close"].":00")<=time()){
               // die("over");
                die("<script>window.location.href=\"index.php?result=over\";</script>");
            }
        }

        $subject=addslashes($_POST['subject_name']);
        $flag=addslashes($_POST['flag']);
        $teams=addslashes($_SESSION['TeamName']);

        //获取一血加成分
        $subject_one = unserialize(file_get_contents("data/one.dat"));

        #一血查询
        $one_sql = mysqli_query($conn, 'select * from submit_info order by sumbit_date;');
        $ones = [];
        while ($ro = mysqli_fetch_assoc($one_sql)) {
            $ones[] = $ro;
        }
        mysqli_free_result($one_sql); //释放结果集
       
       $is_one=true;
       for ($n = 0; $n < count($ones); $n++) {
            if ($subject == $ones[$n]["subject"]) {
                $is_one=false;
                break;
            }
        }

        foreach ($subjects as $key => $value) {
            if ($value["subject_flag"] == $flag and $value["subject_name"] == $subject) {
                $search_sql = "select subject,team from submit_info where subject='$subject' && team='$teams'";
                $names = mysqli_query($conn, $search_sql);
                if (mysqli_num_rows($names) > 0) {
                    //die("repeat");
                    die("<script>window.location.href=\"index.php?result=repeat\";</script>");
                }

                $sum_sql = "insert into submit_info (team,subject,sumbit_date,score) values ('" . $teams . "','" . $subject . "','" .time(). "','" . $value['subject_score'] . "')";
                if ($conn->query($sum_sql) === TRUE) {
                    //echo "sucess";
                    if($is_one==true){
                        $userscore_sql="update  score_info set  sumbit_date='".time()."',score=score+".$value['subject_score'].'+'.$subject_one["one_score"]." where team='".$teams."'";
                        $conn->query($userscore_sql);
                        //一血公告
                        $notice_sql="insert into notice_info (notice) values ('".addslashes('恭喜'.$teams.'获得《'.$subject.'》题目一血')."')";
                        $conn->query($notice_sql);
                    }else{
                        $userscore_sql="update  score_info set  sumbit_date='".time()."',score=score+".$value['subject_score']." where team='".$teams."'";
                        $conn->query($userscore_sql);
                    }
                    //die("success");
                    die("<script>window.location.href=\"index.php?result=success\";</script>");
                }
            }
        }
        //die("error");
        die("<script>window.location.href=\"index.php?result=error\";</script>");
    }

    //公告信息添加
    $notice = $_POST['notice'];
    if ($_GET['action']=='noteadd'){
        include("check_login.php");
        if($_POST['notice']==""){
            die("<script>alert('输入错误');window.location.href=\"admin_Notice.php\";</script>");
        }
        $notice_sql="insert into notice_info (notice) values ('".addslashes($notice)."')";
        if ($conn->query($notice_sql) === TRUE){
            die("<script>window.location.href=\"admin_Notice.php\";</script>");
        }
    }

    //公告信息删除
    if($_GET['action']=='noticedel'){
        include("check_login.php");
        $noteadds=$_GET['notdel'];
        foreach ($notices as $key=>$value){
            if($value['notice']==$noteadds){
                $notice_del="delete from notice_info where notice ='".$noteadds."'";
                $del = mysqli_query($conn,$notice_del);
                if ($del) {
                    die("<script>window.location.href=\"admin_Notice.php\";</script>");
                }
            }
        }
    }

    #上传附件
    if($_GET['action']=='uploadfile') {
        include("check_login.php");
        if(!empty($_FILES["file"])){
            $tmp_name = $_FILES["file"]["tmp_name"];
            $name = $_FILES["file"]["name"];
            $ext = substr($name,strrpos($name,".")+1);
            if($ext!="zip"){
                die("<script>alert('只能提交zip');window.location.href=\"admin_file.php\";</script>");
            }
            @move_uploaded_file($tmp_name,"file/$name");
            die("<script>window.location.href=\"admin_file.php\";</script>");


        }else{
            die("非法访问");
        }
    }
    #删除附件
    if($_GET['action']=='delfile') {
        include("check_login.php");
        $name = $_GET["file"];
        $ext = substr($name,strrpos($name,".")+1);
        if($ext!="zip"){
            die("非法访问");
        }
        @unlink($name);
        die("<script>window.location.href=\"admin_file.php\";</script>");
    }

    #竞赛标题保存
    if($_GET['action']=='subjecttitle') {
        include("check_login.php");
        $name=$_POST['name'];
        if(!file_exists("data/title.dat")){
            file_put_contents("data/title.dat","a:0:{}");
        }
        $title_name["title"]=$name;
        file_put_contents("data/title.dat",serialize($title_name));
        die("<script>window.location.href=\"admin_SetMatch.php\";</script>");
    }

    #一血加成分
    if($_GET['action']=='subjectone') {
        include("check_login.php");
        $one_score=$_POST['one_score'];
        if(!file_exists("data/one.dat")){
            file_put_contents("data/one.dat","a:0:{}");
        }
        $subject_one["one_score"]=intval($one_score);
        file_put_contents("data/one.dat",serialize($subject_one));
        die("<script>window.location.href=\"admin_SetMatch.php\";</script>");
    }

    #竞赛时间保存
    if($_GET['action']=='matchtime') {
        include("check_login.php");
        $start=$_POST["start"];
        $close=$_POST["close"];
        $data=["start"=>$_POST["start"],"close"=>$_POST["close"]];
        if(!file_exists("data/match_time.dat")){
            file_put_contents("data/match_time.dat","a:0:{}");
        }
        file_put_contents("data/match_time.dat",serialize($data));
        die("<script>window.location.href=\"admin_SetMatch.php\";</script>");
    }
    #获取排行榜
    if($_GET['action']=='getrank') {
        include("session.php");
        echo json_encode($scores);
    }


    #成绩榜单
    if($_GET['action']=='results') {
        include("session.php");
        #查询解题记录及成绩
        $rank_results_sql = mysqli_query($conn, 'select b.team,a.subject_type,b.subject,b.sumbit_date,score from subject_info a join submit_info b where b.subject=a.subject_name;');
        $rank_results = [];
        while ($ro = mysqli_fetch_assoc($rank_results_sql)) {
            $rank_results[] = $ro;
        }
        mysqli_free_result($rank_results_sql); //释放结果集
        #查询战队
        $teams_sql = mysqli_query($conn, 'select distinct a.team,b.company from submit_info a join platform_user b where a.team=b.team_info;');
        $teams = [];
        while ($ro = mysqli_fetch_assoc($teams_sql)) {
            $teams[] = $ro;
        }
        mysqli_free_result($teams_sql); //释放结果集
        #一血查询
        $one_sql = mysqli_query($conn, 'select * from submit_info order by sumbit_date;');
        $ones = [];
        while ($ro = mysqli_fetch_assoc($one_sql)) {
            $ones[] = $ro;
        }
        mysqli_free_result($one_sql); //释放结果集


        //计算结果
        $new_results=[];
        for($i=0;$i<count($teams);$i++) {
            for ($u = 0; $u < count($rank_results); $u++) {
                if ($teams[$i]["team"] == $rank_results[$u]["team"]) {
                    $new_results[$teams[$i]["team"]][$rank_results[$u]["subject_type"]] += 1;
                    $new_results[$teams[$i]["team"]]["team"] = $teams[$i]["team"];
                    $new_results[$teams[$i]["team"]]["company"] = $teams[$i]["company"];
                    //var_dump($rank_results[$u]["subject"]);
                    //判断一血
                    for ($n = 0; $n < count($ones); $n++) {
                        if ($rank_results[$u]["subject"] == $ones[$n]["subject"]) {
                            if ($rank_results[$u]["team"] == $ones[$n]["team"]) {
                                $new_results[$teams[$i]["team"]]["one"] += 1;
                            }
                            break;
                        }
                    }

                }
            }

            for ($o = 0; $o < count($scores); $o++) {
                if ($teams[$i]["team"] == $scores[$o]["team"]) {
                    $new_results[$teams[$i]["team"]]["score"] = $scores[$o]["score"];
                    $new_results[$teams[$i]["team"]]["sumbit_date"] = $scores[$o]["sumbit_date"];
                }
            }
        }

            //补充
            for($o=0;$o<count($teams);$o++){
                if(!array_key_exists("Misc",$new_results[$teams[$o]["team"]]))$new_results[$teams[$o]["team"]]["Misc"]=0;
                if(!array_key_exists("Web",$new_results[$teams[$o]["team"]]))$new_results[$teams[$o]["team"]]["Web"]=0;
                if(!array_key_exists("Crypto",$new_results[$teams[$o]["team"]]))$new_results[$teams[$o]["team"]]["Crypto"]=0;
                if(!array_key_exists("Reverse",$new_results[$teams[$o]["team"]]))$new_results[$teams[$o]["team"]]["Reverse"]=0;
                if(!array_key_exists("Pwn",$new_results[$teams[$o]["team"]]))$new_results[$teams[$o]["team"]]["Pwn"]=0;
                if(!array_key_exists("one",$new_results[$teams[$o]["team"]]))$new_results[$teams[$o]["team"]]["one"]=0;
            }
       // var_dump($new_results);
           // 转换
            $new_results_2=[];
            $i=0;
            foreach ($new_results as $k => $v){
                $new_results_2[$i]=$v;
                $i+=1;
            }

        echo json_encode($new_results_2);
    }

    #比赛数据管理
    if($_GET['action']=='delete_data') {
        include("check_login.php");
        if(isset($_POST["notice"])){
            $sql = " delete from notice_info";
            $result = $conn->query($sql);
        }
        if(isset($_POST["subject"])){
            $sql = " delete from subject_info";
            $result = $conn->query($sql);
        }
        if(isset($_POST["score"])){
            $sql = " delete from score_info";
            $result = $conn->query($sql);
            $sql = " delete from submit_info";
            $result = $conn->query($sql);
            #查询战队
        	$teams_sql = mysqli_query($conn, 'select team_info from platform_user;');
        	$teams_results = [];
       		 while ($ro = mysqli_fetch_assoc($teams_sql)) {
            	$teams_results[] = $ro;
        	}
        	mysqli_free_result($teams_sql); //释放结果集
        	for ($o = 0; $o < count($teams_results); $o++) {
        		$sql = " insert into score_info values('".$teams_results[$o]["team_info"]."','0',0)";
        		$result = $conn->query($sql);
        	}

        }
        if(isset($_POST["team"])){
            $sql = " delete from platform_user";
            $result = $conn->query($sql);
        }
        if(isset($_POST["file"])){
            system("rm -f file/*");
        }
        die("<script>window.location.href=\"admin_SetMatch.php\";</script>");
    }
}
mysqli_close($conn);
?>
