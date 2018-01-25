<?php
class UserAdmin {

    private $model;

    function UserAdmin($model)
    {

        $this->model = $model;
    }

    public function usernameCheck($uid)
    {
        $uid = $uid;
        $rs = $this->model->executeCommand("SELECT username FROM usuarios WHERE uid='$uid'");
        if (!$rs->EOF) {
            return $rs->fields['username'];
        } else {
            return false;
        }
    }

    public function User_Login($username, $password)
    {
        $username = $username;
        $password = $password;

        $rs = $this->model->executeCommand("SELECT uid FROM usuarios WHERE username='$username' and password='$password'");
        if (!$rs->EOF)
            return $rs->fields['uid'];

        return 0;

    }
	public function User_Delete($uid){
//echo "eliminado";
       $this->model->executeCommand("DELETE FROM usuarios WHERE uid='$uid'");
    }
    public function User_Data($uid)
    {
        $rs = $this->model->executeCommand("SELECT * FROM usuarios WHERE uid='$uid'");
        return $rs;

    }


} 