<?php
    header('Access-Control-Allow-Origin:*');
    require_once '../tools/tools.php';
    $saveurl = '../../ad/static/show/';
    $file = $_FILES['file'];
    $filename = $file['name'];
    $name = $_POST['user'];
    $now = $_POST['pid'];
    $test = move_uploaded_file($file['tmp_name'],$saveurl.iconv("UTF-8","gb2312",$filename));
    if($test){
        $url = $filename;
        $test = new tools(); 
        $con = $test ->connect();
        if($con){
            $test->setCode($con);
            echo $now;
            if($now==0){
                $url = $url.';';
                $sql_login = $test->update('ad_show',"user_show='$url'","user_account='$name'");
                $res = $con->query($sql_login);
                if($res){
                    $back_data =array("msg"=>"success","code"=>"1","data"=>'上传成功');
                    echo json_encode($back_data); 
                }else{
                    $back_data =array("msg"=>"failed","code"=>"0","data"=>'用户名或密码错误');
                    echo json_encode($back_data); 
                }
            }else{
                $sql_find = $test->search('*','ad_show',"user_account='$name'");
                $res_find = $con->query($sql_find);
                $resArr = array();
                if($res_find->num_rows==1){
                    $resArr = $test->filters($res_find,$resArr);
                }
                $url = $resArr[0]['user_show'].$url.';';
                $sql_login = $test->update('ad_show',"user_show='$url'","user_account='$name'");
                $res = $con->query($sql_login);
                if($res){
                    $back_data =array("msg"=>"success","code"=>"1","data"=>'上传成功');
                    echo json_encode($back_data); 
                }else{
                    $back_data =array("msg"=>"failed","code"=>"0","data"=>'用户名或密码错误');
                    echo json_encode($back_data); 
                }
            }
        }else{
            $back_data =array("msg"=>"登录失败","code"=>"-1","data"=>'数据库连接不成功');
            echo json_encode($back_data);
        }
    }