<?php

class NewsModel{
    
    private $db;
    
    public function __construct($dbo)
    {
        $this->db = $dbo;
    }

    public function getListAllNews()
    {
        $sql = "SELECT * FROM ".TBL_NEWS."";

        $res = $this->db->query($sql);

        return $res;
    }
    
    public function getNewsById($news_id)
    {
        $sql = "SELECT * FROM ".TBL_NEWS." WHERE id='".$news_id."'";

        $res = $this->db->query($sql);

        if(count($res) > 0)
            return $res[0];

        return false;
    }

    public function addNewNews($news_title, $news_content)
    {
        $sql = "INSERT INTO ".TBL_NEWS." (title, textPub, datePub) VALUES ('".addslashes($news_title)."', '".addslashes($news_content)."', now())";

        return $this->db->execute($sql);
    }

    public function deleteNews($news_id)
    {
        $sql = "DELETE FROM ".TBL_NEWS." WHERE id='".$news_id."'";
        $this->db->execute($sql);
    }

    public function updateInfoNews($news_id, $news_title, $news_content) 
    {
        $sql = "UPDATE ".TBL_NEWS." SET title='".addslashes($news_title)."', textPub='".addslashes($news_content)."', datePub = now() WHERE id='".$news_id."'";

        return $this->db->execute($sql);
    }

    public function checkNewsTitleExistInBase($news_title)
    {
        $sql = "SELECT * FROM ".TBL_NEWS." WHERE title='".addslashes($news_title)."'";

        $res = $this->db->query($sql);

        if(count($res) > 0)
            return true;

        return false;
    }

    public function checkNewsContentExistInBase($news_content)
    {
        $sql = "SELECT * FROM ".TBL_NEWS." WHERE textPub='".addslashes($news_content)."'";

        $res = $this->db->query($sql);

        if(count($res) > 0)
            return true;

        return false;
    }
}

