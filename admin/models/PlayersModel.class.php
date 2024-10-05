<?php

/*
class Model{
	protected $db;
	
	public function __construct($dbo)
	{
		$this->db = $dbo;
	}
}
*/
class PlayersModel /*extends Model*/{
	
	private $db;
	
	public function __construct($dbo)
	{
		$this->db = $dbo;
		//parent::__construct($dbo);
	}	
	
	public function getList($category_id = 0)
	{
		
        $sql = "SELECT p1.*, c.name as category 
                FROM ".TBL_PLAYERS." p1 
                LEFT JOIN ".TBL_CATEGORIES." c ON p1.category_id = c.id 
                ".($category_id != 0 ? "WHERE p1.category_id=".intval($category_id) : "");
		
		$res = $this->db->query($sql);
		
		return $res;
	}
	
	public function getItem($player_id)
	{
		$sql = "SELECT p1.* 
		FROM ".TBL_PLAYERS." p1 
		WHERE p1.id=".intval($player_id)." ";
		
		$res = $this->db->query($sql);
		if( count($res) > 0 )
			return $res[0];
		
		return false;
	}
	
	public function delete($player_id)
	{
		$player_id = intval($player_id);
    
	    // Delete player parameters first
	    $this->db->execute("DELETE FROM " . TBL_PARAMETERS . " WHERE player_id = $player_id");
	    
	    // Delete player record
	    $this->db->execute("DELETE FROM " . TBL_PLAYERS . " WHERE id = $player_id");	
	}
	
	public function add($player_name, $player_category_id, $player_salary, $player_number, $player_year, $player_image) 
	{
	    $res = $this->db->execute("INSERT INTO " . TBL_PLAYERS . " 
	    (name, category_id, salary, number, year, image) 
	    VALUES ('".addslashes($player_name)."', '".$player_category_id."', '".$player_salary."', 
	    '".intval($player_number)."', '".$player_year."', '".$player_image."')");
	    
	    if ($res !== false) {
	        return $this->db->lastInsertId();
	    }
	    
	    return false;
	}

	public function update($player_id, $player_name, $player_category_id, $player_salary, $player_number, $player_year, $player_image) 
	{
	    $player_id = intval($player_id);
	    
	    // Update player information
	    $res = $this->db->execute("UPDATE " . TBL_PLAYERS . " SET 
	        name = '" . addslashes($player_name) . "', 
	        category_id = '" . intval($player_category_id) . "', 
	        salary = '" . $player_salary . "', 
	        number = '" . intval($player_number) . "', 
	        year = '" . $player_year . "', 
	        image = '" . $player_image . "' 
	        WHERE id = $player_id");

	    return $res !== false;
	}

    public function checkPlayerExist($name, $number) 
    {
        $sql = "SELECT COUNT(*) as count FROM " . TBL_PLAYERS . " WHERE name = '$name' OR number = '$number'";
        $result = $this->db->query($sql);

        return $result[0]['count'] > 0;
    }
}

?>
