<?php
require('config/config.php');

class user extends mysql
{
    private $table = '';

    //判断用户是否存在
    public function is_exist($username)
    {
        $this->table = 'userinfo';
        $username = parent::filter($username);

        $where = "username = '$username'";
        $result = parent::select($this->table, $where);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    //登录
    public function sign_in($username, $password)
    {
        $this->table = 'userinfo';
        $username = parent::filter($username);
        $password = parent::filter($password);

        $where = "username = '$username'";
        $result = parent::select($this->table, $where);
        if ($result && $result->passwd === md5($password)) {
            $_SESSION['USER'] = $result->userid;
            $_SESSION['USERNAME'] = $result->username;
            return true;
        } else {
            return false;
        }
    }

    
    //注册用户 
    public function sign_up($username, $password)
    {
        $this->table = 'userinfo';
        if($this->is_exist($username)){
            return false;
        }
        $username = parent::filter($username);
        $password = parent::filter($password);
        $created_at = date("Y-m-d H:i:s");

        $key_list = array('username', 'passwd', 'created_at');
        $value_list = array($username, md5($password), $created_at);
        $result = parent::insert($this->table, $key_list, $value_list);
        // die(var_dump($result));
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    //获取用户信息
    public function show_profile()
    {
        $this->table = 'userinfo';
        $userid = $_SESSION['USER'];
        $where = "userid = '$userid'";
        $result = parent::select($this->table, $where);
        return $result;
    }

    //修改用户信息
    public function update_profile($username, $password, $gender, $intro, $email, $phone_number, $avatar)
    {
        $this->table = 'userinfo';
        $userid = $_SESSION['USER'];
        $username = parent::filter($username);
        $password = md5($password);
        $email = parent::filter($email);
        $phone_number = parent::filter($phone_number);
        $intro = parent::filter($intro);
        
        $key_list = array('username', 'passwd', 'gender', 'intro', 'email', 'phone_number', 'avatar');
        $value_list = array($username, $password, $gender, $intro, $email, $phone_number, $avatar);

        $where = "userid = $userid";
        $result = parent::update($this->table, $key_list, $value_list, $where);
        $_SESSION['USERNAME'] = $username;
        return $result;
    }

    //用户退出
    public function sign_out()
    {
        session_destroy();
    }
}

class note extends mysql{
    private $table = '';

    //获取所有笔记

}

class mysql
{
    private $link = null;

    public function connect($config)
    {
        $this->link = mysqli_connect($config['dbserver'], $config['dbuser'], $config['dbpwd'], $config['dbname']);
        if (!$this->link) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function select($table, $where, $ret = '*')
    {
        $sql = "SELECT $ret FROM $table WHERE $where";
        // die($sql);
        $result = mysqli_query($this->link, $sql);
        if (!$result) {
            die("Query failed: " . mysqli_error($this->link));
        }
        return mysqli_fetch_object($result);
    }

    public function insert($table, $key_list, $value_list)
    {
        $key = implode(',', $key_list);
        $value = '\'' . implode('\',\'', $value_list) . '\'';
        $sql = "INSERT INTO $table ($key) VALUES ($value)";
        // die($sql);
        $result = mysqli_query($this->link, $sql);
        return $result;
    }

    public function update($table, $key_list, $value_list, $where)
    {
        $change = '';
        foreach ($key_list as $k => $v) {
            $change = $change . $v . '=' . '\'' . $value_list[$k] . '\'' . ',';
        }
        $change = substr($change, 0, -1);
        $sql = "UPDATE $table SET $change WHERE $where";
        // die($sql);
        $result = mysqli_query($this->link, $sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($table, $where)
    {
        $sql = "DELETE FROM $table WHERE $where";
        $result = mysqli_query($this->link, $sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function filter($string) //转义字符
    {
        $string = mysqli_real_escape_string($this->link, $string);
        return $string;
    }

    public function close()
    {
        mysqli_close($this->link);
    }
}

session_start();

$user = new user();
$user->connect($config);