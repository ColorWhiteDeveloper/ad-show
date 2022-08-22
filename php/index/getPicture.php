<?php
     header('Access-Control-Allow-Origin:*');
     require_once '../tools/tools.php';
     // 获取参数
     $user = $_GET['user'];
     $test = new tools(); 
     $con = $test ->connect();
     if($con){
         $test->setCode($con);
         $sql_get_picture = $test->search('*','ad_show',"user_account='$user'");
         $res = $con->query($sql_get_picture);
         $resArr = array();
         if($res->num_rows==1){
             for($i=0;$row = $res->fetch_assoc();$i++){
                $resArr[$i] = $row;
                break;
             }
             $back_data =array("msg"=>"success","code"=>"1","data"=>$resArr);
             echo json_encode($back_data); 
         }else{
             $back_data =array("msg"=>"failed","code"=>"0","data"=>'查找失败');
             echo json_encode($back_data); 
         }
     }else{
         $back_data =array("msg"=>"failed","code"=>"-1","data"=>'数据库连接不成功');
         echo json_encode($back_data);
     }