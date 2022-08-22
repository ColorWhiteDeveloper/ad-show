<?php
     header('Access-Control-Allow-Origin:*');
     require_once '../tools/tools.php';
     // 获取参数
     $user = $_GET['user'];
     $pwd = $_GET['pwd'];
     $test = new tools(); 
     $con = $test ->connect();
     if($con){
         $test->setCode($con);
         $sql_login = $test->add('ad_show',"values(null,'$user','$pwd','')");
         $res = $con->query($sql_login);
         if($res){
            $back_data =array("msg"=>"success","code"=>"1","data"=>'注册成功');
            echo json_encode($back_data);
         }else{
            $back_data =array("msg"=>"failed","code"=>"0","data"=>'注册失败');
            echo json_encode($back_data);
         }
     }else{
         $back_data =array("msg"=>"failed","code"=>"-1","data"=>'数据库连接不成功');
         echo json_encode($back_data);
     }