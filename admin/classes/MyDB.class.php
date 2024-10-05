<?php
// Класс запроса

class MyDB{
	
	private $db;
	
	public function __construct($login, $pass, $host, $dbname)
	{
		$this->db = new mysqli($host, $login, $pass, $dbname);
	}
	
	public function query($sql)
	{
		$data = Array();
		
		$res = $this->db->query($sql);
		if( $res )
		{			
			
			while($row = $res->fetch_assoc())
			{
				$data[] = $row;
			}
		}
		else
		{
			echo $this->db->error."<br>";
			echo $sql."<br>";
		}
		
		return $data;
	}	
	
	public function execute($sql)
	{
		$res = $this->db->query($sql);
		if( !$res )
		{
			echo $this->db->error."<br>";
			echo $sql."<br>";
			return false;
		}
		
		
		return true;
	}
	
	public function lastInsertId()
	{
		return $this->db->insert_id;
	}
}
