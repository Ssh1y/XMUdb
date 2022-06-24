<?php
require(__DIR__ . '/../Universal/class.php');
if (!isset($_SESSION['IS_ADMIN'])) {
    echo '<script>alert("不允许的访问");window.history.back(-1);</script>';
}

class Admin extends mysql
{
    private $table = '';
    public $link = '';

    public function __construct($link)
    {
        $this->link = $link;
    }

    //设置公告
    public function set_announcement($title, $content)
    {
        $this->table = 'announcement';
        $title = parent::filter($title);
        $content = parent::filter($content);
        $created_at = date('Y-m-d H:i:s');
        $key_list = array('title', 'content', 'created_at');
        $value_list = array($title, $content, $created_at);
        $result = parent::insert($this->table, $key_list, $value_list);
        return $result;
    }

    //获取所有公告
    public function get_all_announcement()
    {
        $this->table = 'announcement';
        $where = '1';
        $result = parent::select($this->table, $where);
        $notices = array();
        while ($row = $result->fetch_assoc()) {
            $notices[] = $row;
        }
        return $notices;
    }

    //删除公告
    public function delete_announcement($announcementid)
    {
        $this->table = 'announcement';
        $where = 'announcementid=' . $announcementid;
        $result = parent::delete($this->table, $where);
        return $result;
    }

    //查看所有用户
    public function get_all_user()
    {
        $this->table = 'userinfo';
        $where = '1';
        $result = parent::select($this->table, $where);
        $users = array();
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        return $users;
    }

    //查看用户的所有文章
    public function get_user_notes($userid)
    {
        $this->table = 'note';
        $where = 'userid=' . $userid;
        $result = parent::select($this->table, $where);
        $notes = array();
        while ($row = $result->fetch_assoc()) {
            $notes[] = $row;
        }
        return $notes;
    }

    //删除用户的某篇文章
    public function delete_user_note($noteid, $userid)
    {
        $this->table = 'note';
        $where = 'noteid=' . $noteid . ' and userid=' . $userid;
        $result = parent::delete($this->table, $where);
        return $result;
    }

    //删除用户
    public function delete_user($userid)
    {
        $this->table = 'userinfo';
        $where = 'userid=' . $userid;
        $result = parent::delete($this->table, $where);
        return $result;
    }

    //设置投票
    public function set_vote($title, $start_time, $endt_ime)
    {
        $this->table = 'vote';
        $title = parent::filter($title);
        $created_at = date('Y-m-d H:i:s');
        $key_list = array('title', 'start_time', 'end_time', 'created_at');
        $value_list = array($title, $start_time, $endt_ime, $created_at);
        // die(var_dump($value_list));
        $result = parent::insert($this->table, $key_list, $value_list);
        if ($result) {
            $where = 'created_at="' . $created_at . '"';
            $ret = 'voteid';
            $voteid = parent::select($this->table, $where, $ret);
            $voteid = $voteid->fetch_assoc();
            $voteid = $voteid['voteid'];
            // die(var_dump($voteid));
            return $voteid;
        } else {
            return false;
        }
    }

    //设置投票选项
    public function set_vote_option($voteid, $options)
    {
        $this->table = 'options';
        $index = 1;
        try {
            foreach ($options as $option) {
                $option = parent::filter($option);
                $key_list = array('voteid', 'o_option', 'o_index');
                $value_list = array($voteid, $option, $index);
                parent::insert($this->table, $key_list, $value_list);
                $index++;
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    //删除投票
    public function delete_vote($voteid)
    {
        $this->table = 'vote';
        $where = 'voteid=' . $voteid;
        $result = parent::delete($this->table, $where);
        return $result;
    }

    //查看所有投票
    public function get_all_vote()
    {
        $this->table = 'vote';
        $where = '1';
        $result = parent::select($this->table, $where);
        $votes = array();
        while ($row = $result->fetch_assoc()) {
            $votes[] = $row;
        }
        return $votes;
    }

    //查看投票的所有选项
    public function get_vote_options($voteid)
    {
        $this->table = 'options';
        $where = 'voteid=' . $voteid;
        $result = parent::select($this->table, $where);
        $options = array();
        while ($row = $result->fetch_assoc()) {
            $options[] = $row;
        }
        return $options;
    }

    //显示某个人的所有信息
    public function show_userinfo($userid)
    {
        $this->table = 'userinfo';
        $result = parent::select($this->table, "userid = $userid");
        $userinfo = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $userinfo[] = $row;
        }
        return $userinfo;
    }
}

$admin = new Admin($user->link);
// var_dump($blog);