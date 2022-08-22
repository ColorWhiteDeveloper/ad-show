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
         $sql_login = $test->search('*','ad_show',"user_account='$user' and user_pwd='$pwd'");
         $res = $con->query($sql_login);
         $resArr = array();
         if($res->num_rows==1){
             for($i=0;$row = $res->fetch_assoc();$i++){
                $resArr[$i] = $row;
                break;
             }
             $back_data =array("msg"=>"登录成功","code"=>"1","data"=>$resArr);
             echo json_encode($back_data); 
         }else{
             $back_data =array("msg"=>"用户名或密码错误","code"=>"0","data"=>'用户名或密码错误');
             echo json_encode($back_data); 
         }
     }else{
         $back_data =array("msg"=>"登录失败","code"=>"-1","data"=>'数据库连接不成功');
         echo json_encode($back_data);
     }