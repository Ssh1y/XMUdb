<?php
require('config/config.php');

class blog extends mysql
{
    private $table = '';
    public $link = null;

    public function __construct($link)
    {
        $this->link = $link;
    }
    //推荐文章
    public function recommend_note()
    {
        $this->table = 'note';
        $sql = "SELECT noteid,title,content,note.userid,username,note.created_at,wordcount,comment_count,like_count FROM $this->table,userinfo WHERE $this->table.userid = userinfo.userid ORDER BY RAND() limit 3";
        // die($sql);
        $result = mysqli_query($this->link, $sql);
        $notes = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $notes[] = $row;
        }
        return $notes;
    }

    //显示最新的两条公告
    public function show_announcement()
    {
        $this->table = 'announcement';
        $sql = "SELECT * FROM $this->table ORDER BY created_at DESC limit 0,2";
        $result = mysqli_query($this->link, $sql);
        $announcements = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $announcements[] = $row;
        }
        return $announcements;
    }

    //搜索文章
    public function search_note($keyword)
    {
        $this->table = 'note';
        $sql = "SELECT * FROM $this->table WHERE title LIKE '%$keyword%' OR content LIKE '%$keyword%' ORDER BY created_at DESC";
        $result = mysqli_query($this->link, $sql);
        $notes = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $notes[] = $row;
        }
        return $notes;
    }

    //搜索相册
    public function search_album($keyword)
    {
        $this->table = 'album';
        $sql = "SELECT * FROM $this->table WHERE 'description' LIKE '%$keyword%' ORDER BY created_at DESC";
        $result = mysqli_query($this->link, $sql);
        $albums = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $albums[] = $row;
        }
        return $albums;
    }

    //搜索公告
    public function search_announcement($keyword)
    {
        $this->table = 'announcement';
        $sql = "SELECT * FROM $this->table WHERE 'description' LIKE '%$keyword%' ORDER BY created_at DESC LIMIT 0,2";
        $result = mysqli_query($this->link, $sql);
        $announcements = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $announcements[] = $row;
        }
        return $announcements;
    }

    //显示评论
    public function show_comments($noteid)
    {
        $this->table = 'comment';
        $sql = "SELECT commentid,noteid,comment.userid,username,avatar,content,comment.created_at,note_owner FROM $this->table,userinfo WHERE noteid = $noteid AND userinfo.userid = $this->table.userid  ORDER BY created_at DESC";
        // die($sql);
        $result = mysqli_query($this->link, $sql);
        $comments = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $comments[] = $row;
        }
        // die(var_dump($comments));
        return $comments;
    }

    //显示某个人的所有文章
    public function show_notes($userid)
    {
        $this->table = 'note';
        $result = parent::select($this->table, "userid = $userid");
        $notes = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $notes[] = $row;
        }
        return $notes;
    }

    //显示某篇文章
    public function show_note_detail($noteid, $userid)
    {
        $this->table = 'note';
        $where = "noteid = $noteid AND userid = $userid";
        $result = parent::select($this->table, $where);
        $note = mysqli_fetch_assoc($result);
        // die(var_dump($note));
        return $note;
    }

    //显示某个人的相册
    public function show_album($userid)
    {
        $this->table = 'album';
        $where = "userid = $userid";
        $result = parent::select($this->table, $where);
        // var_dump($result);
        $photos = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $photos[] = $row;
        }
        return $photos;
    }
}

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
        return mysqli_num_rows($result);
    }

    //登录
    public function sign_in($username, $password)
    {
        $this->table = 'userinfo';
        $username = parent::filter($username);
        $password = parent::filter($password);

        $where = "username = '$username'";

        $result = parent::select($this->table, $where);
        $result = mysqli_fetch_object($result);
        // var_dump($result);
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
        if ($this->is_exist($username)) {
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
    public function update_profile($array)
    {
        if ($array) {
            $this->table = 'userinfo';
            $userid = $_SESSION['USER'];

            // die(var_dump($array));
            //判断key中是否有file
            if (array_key_exists('file', $array)) {
                $avatar = $this->update_avatar($array['file']);
                if ($avatar) {
                    unset($array['file']);
                    $array['avatar'] = $avatar;
                }
            }
            $key_list = array_keys($array);
            $value_list = array_values($array);

            // die(var_dump($key_list, $value_list));
            $where = "userid = $userid";
            $result = parent::update($this->table, $key_list, $value_list, $where);
            if (in_array('username', $key_list)) {
                $_SESSION['USERNAME'] = $array['username'];
            }
            return $result;
        }
    }

    //更改用户头像
    public function update_avatar($file)
    {
        $this->table = 'userinfo';
        $userid = $_SESSION['USER'];
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $file["name"]);
        $extension = end($temp);
        if ((($file["type"] == "image/gif") || ($file["type"] == "image/jpeg") || ($file["type"] == "image/jpg") || ($file["type"] == "image/pjpeg") || ($file["type"] == "image/x-png") || ($file["type"] == "image/png")) && ($file["size"] < 200000) && in_array($extension, $allowedExts)) {
            if ($file["error"] > 0) {
                echo "错误：: " . $file["error"] . "<br>";
            } else {
                $filename = md5(time()) . "." . $extension;
                if ($filepath = "upload/avatar/$userid/") {
                    if (!file_exists($filepath)) {
                        mkdir($filepath, 0777, true);
                    }
                }
                move_uploaded_file($file["tmp_name"], $filepath . $filename);
                $old_avatar = $this->show_profile()->fetch_assoc()['avatar'];
                //判断是否为默认头像
                if (!(strpos($old_avatar, 'upload/default') === 0)) {
                    unlink($old_avatar);
                }
                return $filepath . $filename;
            }
        } else {
            return false;
        }
    }

    //添加文章
    public function add_note($title, $content)
    {
        $this->table = 'note';
        $userid = $_SESSION['USER'];
        $title = parent::filter($title);
        $content = parent::filter($content);
        $created_at = date("Y-m-d H:i:s");
        $wordcount = strlen($content);
        $key_list = array('userid', 'title', 'content', 'created_at', 'wordcount');
        $value_list = array($userid, $title, $content, $created_at, $wordcount);
        $result = parent::insert($this->table, $key_list, $value_list);
        return $result;
    }

    //删除文章
    public function delete_note($noteid)
    {
        $userid = $_SESSION['USER'];
        $this->table = 'note';
        $where = "noteid = $noteid and userid = $userid";
        if (!parent::select($this->table, $where)) {
            return false;
        }
        $result = parent::delete($this->table, $where);
        return $result;
    }

    //修改文章
    public function modify_note($noteid, $title, $content)
    {
        $userid = $_SESSION['USER'];
        $this->table = 'note';
        $title = parent::filter($title);
        $content = parent::filter($content);
        $wordcount = strlen($content);
        $key_list = array('title', 'content', 'wordcount');
        $value_list = array($title, $content, $wordcount);
        $where = "noteid = $noteid and userid = $userid";
        $result = parent::update($this->table, $key_list, $value_list, $where);
        return $result;
    }

    //添加评论
    public function add_comment($noteid, $content, $note_owner)
    {
        $this->table = 'comment';
        $userid = $_SESSION['USER'];
        $noteid = parent::filter($noteid);
        $content = parent::filter($content);
        $created_at = date("Y-m-d H:i:s");
        $key_list = array('userid', 'noteid', 'content', 'created_at', 'note_owner');
        $value_list = array($userid, $noteid, $content, $created_at, $note_owner);
        $result = parent::insert($this->table, $key_list, $value_list);
        if ($result) {
            $this->table = 'note';
            $where = "noteid = $noteid and userid = $note_owner";
            $key_list = array('comment_count');
            $value_list = array('comment_count + 1');
            $result = parent::update($this->table, $key_list, $value_list, $where);
        }
        return $result;
    }

    //删除评论
    public function delete_comment($commentid)
    {
        $userid = $_SESSION['USER'];
        $this->table = 'comment';
        $where = "commentid = $commentid and userid = $userid";
        if (!parent::select($this->table, $where)) {
            return false;
        }
        $result = parent::delete($this->table, $where);
        return $result;
    }

    //添加点赞
    public function add_like($noteid, $note_owner)
    {
        $this->table = 'like';
        $userid = $_SESSION['USER'];
        $noteid = parent::filter($noteid);
        $note_owner = parent::filter($note_owner);
        $created_at = date("Y-m-d H:i:s");
        $key_list = array('userid', 'noteid', 'created_at', 'note_owner');
        $value_list = array($userid, $noteid, $created_at, $note_owner);
        $result = parent::insert($this->table, $key_list, $value_list);
        if ($result) {
            $this->table = 'note';
            $where = "noteid = $noteid and userid = $note_owner";
            $key_list = array('like_count');
            $value_list = array('like_count + 1');
            $result = parent::update($this->table, $key_list, $value_list, $where);
        }
        return $result;
    }

    //取消点赞
    public function delete_like($noteid, $note_owner)
    {
        $this->table = 'like';
        $userid = $_SESSION['USER'];
        $noteid = parent::filter($noteid);
        $note_owner = parent::filter($note_owner);
        $where = "noteid = $noteid and userid = $userid and note_owner = $note_owner";
        if (!parent::select($this->table, $where)) {
            return false;
        }
        $result = parent::delete($this->table, $where);
        if ($result) {
            $this->table = 'note';
            $where = "noteid = $noteid and userid = $note_owner";
            $key_list = array('like_count');
            $value_list = array('like_count - 1');
            $result = parent::update($this->table, $key_list, $value_list, $where);
        }
        return $result;
    }

    //添加照片
    public function add_photo($photo, $description)
    {
        $this->table = 'album';
        $userid = $_SESSION['USER'];
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $photo["name"]);
        $extension = end($temp);
        if ((($photo["type"] == "image/gif")
                || ($photo["type"] == "image/jpeg")
                || ($photo["type"] == "image/jpg")
                || ($photo["type"] == "image/pjpeg")
                || ($photo["type"] == "image/x-png")
                || ($photo["type"] == "image/png"))
            && ($photo["size"] < 2000000)
            && in_array($extension, $allowedExts)
        ) {
            if ($photo["error"] > 0) {
                echo "Return Code: " . $photo["error"] . "<br>";
            } else {
                $description = parent::filter($description);
                $created_at = date("Y-m-d H:i:s");
                $photoname = md5(time()) . "." . $extension;
                $filepath = "upload/album/$userid/";
                if (!file_exists($filepath)) {
                    mkdir($filepath, 0777, true);
                }
                $posion = $filepath . $photoname;

                $key_list = array('userid', 'position', 'description', 'created_at');
                $value_list = array($userid, $posion, $description, $created_at);
                $result = parent::insert($this->table, $key_list, $value_list);
                if ($result) {
                    move_uploaded_file($photo["tmp_name"], $posion);
                    return true;
                } else
                    return false;
            }
        } else {
            return false;
        }
    }

    //删除照片
    public function delete_photo($photoid)
    {
        $userid = $_SESSION['USER'];
        $this->table = 'album';
        $where = "photoid = $photoid and userid = $userid";
        if (!$temp = parent::select($this->table, $where)) {
            return false;
        }
        if (unlink($temp->position)) {
            $result = parent::delete($this->table, $where);
            return $result;
        } else {
            return false;
        }
    }


    //用户退出
    public function sign_out()
    {
        session_destroy();
    }
}

class mysql
{
    public $link = null;

    public function connect($config)
    {
        $this->link = mysqli_connect($config['dbserver'], $config['dbuser'], $config['dbpwd'], $config['dbname']);
        // var_dump($this->link);
        if (!$this->link) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function select($table, $where, $ret = '*')
    {
        $sql = "SELECT $ret FROM $table WHERE $where";
        // echo $sql;
        $result = mysqli_query($this->link, $sql);
        // var_dump($result->fetch_row());
        if (!$result) {
            die("Query failed: " . mysqli_error($this->link));
        }
        return $result;
    }

    public function insert($table, $key_list, $value_list)
    {
        $key = implode(',', $key_list);
        $value = '\'' . implode('\',\'', $value_list) . '\'';
        $sql = "INSERT INTO $table ($key) VALUES ($value)";
        // die($sql);
        $result = mysqli_query($this->link, $sql);
        if (!$result) {
            die("Query failed: " . mysqli_error($this->link));
        }
        return true;
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
        // die($sql);
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

$blog = new blog($user->link);
