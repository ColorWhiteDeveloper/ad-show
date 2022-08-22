<?php
    class tools{
        // 建立数据库连接
        public function connect(){
            $con = mysqli_connect('localhost','root','123456','jzq');
            return $con;
        }
        // 编码
        public function setCode($res){
            mysqli_query($res,"set names utf8");
            mysqli_query($res,"set character_set_client=utf8");
            mysqli_query($res,"set character_set_results=utf8");
        }
        // 查询
        public function search($get_params,$table,$conditon){
            $sql_find = "select $get_params from $table where $conditon";
            return $sql_find; 
        }
        // 插入
        public function add($table,$values){
            $sql_insert = "insert into $table $values";
            return $sql_insert;
        }
        // 更新
        public function update($table,$target,$conditon){
            $sql_update = "update $table set $target where $conditon";
            return $sql_update;
        }
        // 删除
        public function delete($table,$conditon){
            $sql_delete = "delete from $table where $conditon";
            return $sql_delete;
        }
        // 取出数据
        public function filters($res,$arr){
            for($i=0;$row = $res->fetch_assoc();$i++){
                $arr[$i] = $row;
            }
            return $arr;
        }
        // 获取最大Id
        public function getMaxId($arr,$maxId,$id){
            for($i=0;$i<count($arr);$i++){
                if($maxId<$arr[$i][$id]){
                    $maxId = $arr[$i][$id];
                }
            }
            return $maxId+1;
        }
    }