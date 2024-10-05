<?php

class UserModel
{
    private $db;

    public function __construct($dbo)
    {
        $this->db = $dbo;
    }

    public function getListAllUsers()
    {
        $sql = "SELECT * FROM ".TBL_USERS."";
        $res = $this->db->query($sql);
        return $res;
    }

    public function getUserById($id)
    {
        $sql = "SELECT * FROM ".TBL_USERS." WHERE id='".$id."'";
        $res = $this->db->query($sql);

        if(count($res) > 0)
            return $res[0];

        return false;
    }

    public function addNewUser($username, $password, $role)
    {
        $sql = "INSERT INTO ".TBL_USERS." (username, password, role) VALUES ('".addslashes($username)."', PASSWORD('".addslashes($password)."'), '$role')";
        return $this->db->execute($sql);
    }

    public function deleteUser($id)
    {
        $sql = "DELETE FROM ".TBL_USERS_AUTH." WHERE id='".$id."'";
        $this->db->execute($sql);

        $sql = "DELETE FROM ".TBL_USERS." WHERE id='".$id."'";
        $this->db->execute($sql);
    }

    public function updateInfoUser($id, $username, $password, $role) 
    {
        $sql = "UPDATE ".TBL_USERS." SET username='".addslashes($username)."', password=PASSWORD('".addslashes($password)."'), level='".addslashes($role)."' WHERE id='".$id."'";
        return $this->db->execute($sql);
    }

    public function checkLoginExistInBase($username)
    {
        $sql = "SELECT * FROM ".TBL_USERS." WHERE username='".addslashes($username)."'";
        $res = $this->db->query($sql);

        if(count($res) > 0)
            return true;

        return false;
    }
}