<?php


class Session
{
    private $id_ses = "";

    public function __construct($path = "")
    {
        if($path != "")
        {
            session_save_path($path);
        }
        session_start();
        $this->id_ses = session_id();
    }

    public function getSessionId() 
    {
        return $this->id_ses ?: session_id();
    }

    public function getSessionVar($name)
    {
        if(isset($_SESSION[$name]))
            return $_SESSION[$name];

        return null;
    }

    public function setSessionVar($name, $value)
    {
        $_SESSION[$name] = $value;
    }
}