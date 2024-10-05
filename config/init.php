<?php
// Инициализация

session_start();

//define("AUTH_METH_CSV", "csv");
define("AUTH_METH_DB", "db");

define("AUTH_SES_VAR", "im_is_auth");

// DB defines
define("DB_NAME", "k503labs_db1");
define("DB_HOST", "10.0.0.5");
define("DB_LOGIN", "k503labs_u1");
define("DB_PASS", "ILrZkgUc1S");

// database tables defines
//define("TBL_PREF", "TesterKP_");
define("TBL_PREF", "Hanzera_");
define("TBL_USERS", TBL_PREF."users");
define("TBL_USERS_AUTH", TBL_PREF."users_auth");
define("TBL_NEWS", TBL_PREF."news");
define("TBL_SITE_PARAM", TBL_PREF."site_param");
define("TBL_PLAYERS", TBL_PREF."players");
define("TBL_CATEGORIES", TBL_PREF."sects");
define("TBL_PARAMETERS", TBL_PREF."param");


//////////////////////////
//
//	/
//		/config
//			init.php		
//		/classes
//			Request.class.php
//			Auth.class.php


function myclassLoader($clsName)
{
	$cls_fname = __DIR__."/../admin/classes/".$clsName.".class.php";
	
	//$resp = strpos($clsName, "Model");
	//var_dump($resp);
	//echo "<Br>";
	
	if( strpos($clsName, "Model") !== FALSE )
		$cls_fname = __DIR__."/../admin/models/".$clsName.".class.php";	
	echo "Load check file: ".$cls_fname."<Br>";
	if( file_exists($cls_fname) )
	{
		include $cls_fname;
	}
}

spl_autoload_register('myclassLoader');


// Create global classes
$db = new MyDB(DB_LOGIN, DB_PASS, DB_HOST, DB_NAME);
$UserSes = new UserSession($db);

