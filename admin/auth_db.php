<?php
// Создание базы
// Init engine
include "../config/init.php";


// Run current module code
$login = Request::getVar("login", "");
$password = Request::getVar("password", "");
$action = Request::getVar("action", "");

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>auth db</title>
</head>
<body>
<?php
/*
$db = new mysqli(DB_HOST, DB_LOGIN, DB_PASS, DB_NAME);
if( $db->connect_error )
{
	echo $db->connect_error."<br>";
}

echo "DB Connected<br>";
*/
/*
$res = $db->query("SELECT * FROM testTable1");
if( $res )
{
	while( $row = $res->fetch_assoc() )
	{
		var_dump($row);
		echo "<br>";
	}
}
*/

echo "Drop tables: <br>";
// Drop db structure
$res = $db->execute("DROP TABLE ".TBL_PLAYERS);
$res = $db->execute("DROP TABLE ".TBL_CATEGORIES);
$res = $db->execute("DROP TABLE ".TBL_PARAMETERS);
$res = $db->execute("DROP TABLE ".TBL_USERS);
$res = $db->execute("DROP TABLE ".TBL_USERS_AUTH);
$res = $db->execute("DROP TABLE ".TBL_NEWS);
$res = $db->execute("DROP TABLE ".TBL_SITE_PARAM);
echo "Done<br>";

// Init db structure
echo "Create tables: <br>";
$res = $db->execute("CREATE TABLE ".TBL_PLAYERS."(
    id integer NOT NULL AUTO_INCREMENT,
    name varchar(50) NOT NULL DEFAULT '',
    category_id integer NOT NULL,
    salary decimal(8,2) NOT NULL DEFAULT '0.00',
    number varchar(20) NOT NULL DEFAULT '',
    year integer NOT NULL,
    image varchar(255) NOT NULL DEFAULT '',
    PRIMARY KEY (id),
	KEY (category_id)
    ".( false ? "FOREIGN KEY (category_id) REFERENCES ".TBL_CATEGORIES."(id)" : "" )."
)");

$res = $db->execute("CREATE TABLE ".TBL_CATEGORIES."(
    id integer NOT NULL AUTO_INCREMENT,
    name varchar(50) NOT NULL DEFAULT '',
    PRIMARY KEY (id)    
)");

$res = $db->execute("CREATE TABLE ".TBL_PARAMETERS."(
    id integer NOT NULL AUTO_INCREMENT,
    player_id integer NOT NULL,
    name varchar(20) NOT NULL DEFAULT '',
    value decimal(8,2) NOT NULL DEFAULT '0.00',
    PRIMARY KEY (id) ".( false ? ",
    FOREIGN KEY (player_id) REFERENCES ".TBL_PLAYERS."(id) " : "" )."
)");

$res = $db->execute("CREATE TABLE ".TBL_USERS."(
    id integer NOT NULL AUTO_INCREMENT,
    is_active integer NOT NULL DEFAULT '1',
    username varchar(20) NOT NULL DEFAULT '' UNIQUE,
    password varchar(255) NOT NULL DEFAULT '',
    role varchar(20) NOT NULL DEFAULT 'user',
    PRIMARY KEY (id)    
)");

$res = $db->execute("INSERT INTO ".TBL_USERS."(username, password, role) VALUES('admin54', PASSWORD('me pass123'), 'host')");
$res = $db->execute("INSERT INTO ".TBL_USERS."(username, password, role) VALUES('admin1', PASSWORD('mepass11'), 'admin')");
$res = $db->execute("INSERT INTO ".TBL_USERS."(username, password, role) VALUES('admin2', PASSWORD('mepass22'), 'admin')");

$res = $db->execute("CREATE TABLE ".TBL_USERS_AUTH."(
    id integer NOT NULL AUTO_INCREMENT,
    user_id integer NOT NULL,
    session_id varchar(50) NOT NULL DEFAULT '',
    add_date datetime,
    last_access datetime,
    ip varchar(50) NOT NULL DEFAULT '',
    PRIMARY KEY(id) 
)");

$res = $db->execute("CREATE TABLE ".TBL_NEWS."(
    id integer NOT NULL AUTO_INCREMENT,
    title varchar(20) NOT NULL DEFAULT '',
    datePub datetime,
    textPub text NOT NULL DEFAULT '',
    PRIMARY KEY (id)    
)");

$res = $db->execute("CREATE TABLE ".TBL_SITE_PARAM."(
    id integer NOT NULL AUTO_INCREMENT,
    title varchar(20) NOT NULL DEFAULT '',
    logo varchar(100) NOT NULL DEFAULT '',
    textSite text NOT NULL DEFAULT '',
    PRIMARY KEY (id)    
)");

// Insert data
echo "Insert data: <br>";
$categories = [
    'Leader',
    'Defender',
    'Attack',
    'Gate'
];

foreach ($categories as $category) {
    $res = $db->execute("INSERT INTO ".TBL_CATEGORIES." (name) VALUES ('$category')");
}

$xml = simplexml_load_file('../pages/players.xml');

echo "Done<br>";

$pModel = new PlayersModel($db);

foreach ($xml->players->player as $player) {
	$newplayer = Array();
    $newplayer['name'] = $name = $player->name;	// Jon's St'ddd
    $newplayer['category'] = $category = $player->category;
    $newplayer['salary'] = $salary = $player->salary;
    $newplayer['number'] = $number = $player->number;
    $newplayer['year'] = $year = $player->year;
    $newplayer['image'] = $image = $player->image;
	
	echo "Adding player: ".$name.", cat: ".$category."<br>";

	$category_id = 0;
    $category_id_query = $db->query(
		"SELECT id FROM ".TBL_CATEGORIES." 
		WHERE name = '$category'"
	);
	if( count($category_id_query)>0 )
	{
		$category_id = $category_id_query[0]['id'];
	}
	
	echo "Cat id for '".$category."':". $category_id."<br>";

	$newplayer['parameters'] = $player->parameters->parameter;
	
	$pModel->add($newplayer);
	
	
	/*
	
	//$vvv = "some'); UPDATE table1 ... ";	
	//$year = $a - $b;
	
	echo "Player: ".$name." == ".mysqli_real_escape_string($name)."<br>";
	
    $res = $db->execute("INSERT INTO ".TBL_PLAYERS." 
		(name, category_id, salary, number, year, image) 
		VALUES ('".addslashes($name)."', '$category_id', '$salary', 
		'".intval($number)."', '$year', '$image')");
		
	//$db->query("INSERT INTO tbl1 (a,b,c) VALUES(:var1, :var2, :var3)", 
	//["var1" => "abc", "var2" => "ncbcb", "var3" => "avd'ddff"]);

    $player_id = $db->lastInsertId();

    foreach ($player->parameters->parameter as $parameter) {
        $type = $parameter['type'];
        $value = $parameter;
        $res = $db->execute("INSERT INTO ".TBL_PARAMETERS." 
			(player_id, name, value) VALUES 
			('$player_id', '$type', '$value')");
    }
	*/
    
}


//var_dump($res);

?>
</body>
</html>
