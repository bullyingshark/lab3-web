<?php

class UserSession extends Session
{
    protected $user_id = 0;
    protected $user_login = "";
    protected $MyDB;

    public function __construct($dbo, $path = "")
    {
        parent::__construct($path);

        $this->MyDB = $dbo;

        $this->checkUserAuth();
    }

    public function checkUserAuth()
    {
        $this->user_id = 0;
        $this->user_login = "";

        $sql = "SELECT u1.* FROM ".TBL_USERS_AUTH." a1
                INNER JOIN ".TBL_USERS." u1 ON a1.user_id = u1.id
                WHERE a1.ip = '".$_SERVER['REMOTE_ADDR']."' AND a1.session_id ='".$this->getSessionId()."'";

        $res = $this->MyDB->query($sql); //$res = $this->MyDB->execute($sql);
        if (count($res) > 0) //if ($res && count($res) > 0)
        {
            $row = $res[0];

            $this->user_id = $row['id'];
            $this->user_login = $row['username'];

            echo "Auth ok<br>";
        }

        return ($this->user_id != 0);
    }

    public function isLogged()
    {
        return ($this->user_id !=0);
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getUserLogin()
    {
        return $this->user_login;
    }

    public function logout()
    {
        $sql = "DELETE FROM ".TBL_USERS_AUTH." WHERE session_id ='".$this->getSessionId()."'";
        $this->MyDB->execute($sql);

        $this->user_id = 0;
        $this->user_login = "";
    }

    
    public function makeUserLogin($user_login, $user_password)
    {
        if($this->isLogged())
        {
            return true;
        }

        $sql = "SELECT username, id FROM ".TBL_USERS." WHERE username ='".addslashes($user_login)."' AND password=PASSWORD('".addslashes($user_password)."')";

        $res = $this->MyDB->query($sql);


        if (count($res) > 0)
        {
            if($this->addUserSession($res[0]['id']))
            {
                $this->user_id = $res[0]['id'];
                $this->user_login = $res[0]['username'];

                echo "Auth ok";

                return true;

            }
        }

        return false;
    }

    public function addUserSession($user_id) 
    {
        $sql = "INSERT INTO ".TBL_USERS_AUTH." (session_id, ip, user_id, add_date, last_access)
                VALUES ('".$this->getSessionId()."', '".$_SERVER['REMOTE_ADDR']."', '".$user_id."', now(), now())";

        return $this->MyDB->execute($sql);
    }


}