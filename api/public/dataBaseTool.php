<?php
include __DIR__."/config.php";
class DataBaseTool
{
    public $conn;
    public function __construct()
    {
        // 1、连接数据库
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
        //2、判断数据库是否连接成功
        if ($this->conn->connect_error) {
            die('连接数据库失败' . $this->conn->connect_error);
        }
        //3、设置字符集
        $this->conn->set_charset('utf8');
    }

    public function __destruct()
    {
        $this->conn->close();
    }
    public function close()
    {
        $this->conn->close();
    }

    public function selectOne($sql)
    {
        //执行SQL语句
        $result = $this->conn->query($sql);
        //判断SQL是否执行成功
        if ($result != false) {
            //判断是否登录登录成功
            $data = [];
            if ($result->num_rows > 0) {
                //获取 数据
                $row = $result->fetch_assoc();
                array_push($data, $row);
                return $data;
            } else {
                return false;
            }

        } else {
            return $this->conn->error;
        }
    }

    public function selectAll($sql)
    { 
        //1、执行SQL语句
        $result = $this->conn->query($sql);
        //2、判断语句是否执行成功
        if($result !=false){
            //3、、判断是否登录成功
            $data = [];
            if($result->num_rows>0){
                //4、获取数据
                while($row = $result->fetch_assoc()){
                    array_push($data,$row);
                }
                return $data;
            }else{
                return false;
            }

        }else{
            return $this->conn->error;
        }
    }

    function insert($sql){
        //1、执行SQL语句
       $success =  $this->conn->query($sql);
       //2、、判断语句是否执行成功
        if($success){
            //3、判断 插入 是否 成功
            if($this->conn->affected_rows>0){
                return true;
            }else{
                return false;

            }
        }else{
            return $this->conn->error;

        }
    }

    function delete($sql){
        //1、执行SQL语句
       $success =  $this->conn->query($sql);
       //2、、判断语句是否执行成功
        if($success){
            //3、判断 删除 是否 成功
            if($this->conn->affected_rows>0){
                return true;
            }else{
                return false;

            }
        }else{
            return $this->conn->error;

        }
    }

    function update($sql){
        //1、执行SQL语句
       $success =  $this->conn->query($sql);
       //2、判断语句是否执行成功
        if($success){
            return true;
        }else{
            return $this->conn->error;

        }
    }
}
