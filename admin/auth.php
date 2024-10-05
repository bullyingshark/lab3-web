<?php

// Init engine
include "../config/init.php";

// MVC - Model/View/Controller - 3 level architecture

//////////////////////////////////////////////////////////
//
//  CONTROLLER

ini_set('display_errors', 1);
error_reporting(E_ALL);

$login = Request::getHttpVar("login", "");
$password = Request::getHttpVar("password", "");
$action = Request::getHttpVar("action", "");

$msg = "";

if ($UserSes->isLogged() && $action != "logout") {
    header("Location: adm-pan.php");
    exit();
}

switch ($action) {
    case "logout":
        $UserSes->logout();
        header("Location: auth.php");
        exit();

    case "login":
        $login = Request::getHttpVar("login", "");
        $password = Request::getHttpVar("password", "");

        if ($UserSes->makeUserLogin($login, $password)) {   
            $_SESSION['user_session'] = serialize($UserSes);
            header("Location: adm-pan.php");
            exit();
        }

        $msg = "Error. Check the data you entered";
        break;
}

/////////////////////////////////////////////////////////

////////////////////////////////////////////
// Make page view
// 

include "inc/header-min.php";

?>
<?php
    //echo 'string md5 for admin1 "mepass11" == '.md5('mepass11').'<br>';
    //echo 'string md5 for admin2 "my pass22" == '.md5('my pass22').'<br>';

    //echo 'Session for: '.session_id().'<br>';
    //var_dump($_SESSION);
    //echo '<br><br>';
	//echo $UserSes->isLogged() ? "LOGGED" : "NOT";
    //$pModel = new PlayersModel($db);
    //$plist = $pModel->getList();
    //var_dump($plist);

    //$newsModel = new NewsModel($db);
    //$allNews = $newsModel->getListAllNews();
    //var_dump($allNews);

?>
<div style="margin-left: 250px; margin-bottom: 40px; padding-top: 60px;">
<?php
    echo '<div style="color:red; padding: 10px 40px;">' . ($UserSes->isLogged() ? 'Form action Now Authorized' : 'Form action Now Guest') . '</div>';

    if ($UserSes->isLogged()) {
        echo "You are logged in as: " . $UserSes->getUserLogin() . "<br>";
        echo '<a href="?action=logout">Logout</a><br>';
    } else {
?>


    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
        <input type="hidden" name="action" value="login">
        <table>
            <tr>
                <td>Login</td>
                <td><input type="text" name="login"></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Authentication" style="background-color: #2860868a; border-color: #286086; border-radius: 10px;"></td>
            </tr>
            <p style="color: red; padding: 0 20px 20px;">
                <?php
                    if (!empty($msg)) {
                        echo $msg;
                    }
                ?>
            </p>
        </table>
    </form>
</div>

<?php
}
include "inc/footer-min.php";
?>
