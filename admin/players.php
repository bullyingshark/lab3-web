<?php

include "../config/init.php";

echo "<br> Sesid: " . $UserSes->getSessionId() . "<br>";

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!$UserSes->isLogged()) {
    header("Location: auth.php");
    exit();
}

$action = Request::getHttpVar("action", "");
$viewMode = Array();

$player_name = Request::getHttpVar("player_name", "");
$player_category = Request::getHttpVar("player_category", "");
$player_salary = Request::getHttpVar("player_salary", 0.00, "float");
$player_number = Request::getHttpVar("player_number", "");
$player_year = Request::getHttpVar("player_year", 0, "int");
$player_image = Request::getHttpVar("player_image", "");

$msg = "";

$playerModel = new PlayersModel($db);
$players_list = $playerModel->getList(); // Объявляем $players_list

// Define actions
switch ($action) {
    case "Edit":
        $player_id = Request::getHttpVar("player_id", 0, "int");
        if ($player_id == 0) break;

        $viewMode[] = "PlayerList";
        $viewMode[] = "PlayerEdit";

        $player_info = $playerModel->getItem($player_id);
        $player_name = $player_info['name'];
        $player_category = $player_info['category_id'];
        $player_salary = $player_info['salary'];
        $player_number = $player_info['number'];
        $player_year = $player_info['year'];
        $player_image = $player_info['image'];
        break;

    case "Del":
        $player_id = Request::getHttpVar("player_id", 0, "int");
        if ($player_id == 0) break;

        $playerModel->delete($player_id);
        break;

    case "Update":
        $player_id = Request::getHttpVar("player_id", 0, "int");
        if ($player_id == 0) break;

        if (empty($player_name) || empty($player_category) || empty($player_number) || empty($player_year)) {
            $msg = "All fields are required.";
            $viewMode[] = "PlayerEdit";
            break;
        }

        if ($playerModel->update($player_id, $player_name, $player_category, $player_salary, $player_number, $player_year, $player_image)) {
            $player_name = "";
            $player_category = "";
            $player_salary = 0.00;
            $player_number = "";
            $player_year = 0;
            $player_image = "";
        }

        break;

    case "Add":
        if ($playerModel->checkPlayerExist($player_name, $player_number)) {
            $msg = "Player with this name or number already exists.";
            break;
        }

        if ($playerModel->add($player_name, $player_category, $player_salary, $player_number, $player_year, $player_image)) {
            $player_name = "";
            $player_category = "";
            $player_salary = 0.00;
            $player_number = "";
            $player_year = 0;
            $player_image = "";
        }

        break;
}

if (count($viewMode) == 0) {
    $viewMode[] = "PlayerList";
    $viewMode[] = "PlayerAdd";
}

include "inc/adm-header-min.php";

for ($iv = 0; $iv < count($viewMode); $iv++) {
    if ($viewMode[$iv] == "PlayerEdit") {
        include "views/players/playersEdit.php";
    } else if ($viewMode[$iv] == "PlayerList") {
        include "views/players/playersList.php";
    } else if ($viewMode[$iv] == "PlayerAdd") {
        include "views/players/playersAdd.php";
    }
}

if ($msg != "") {
    echo '<div style="color: red; text-align:center;">' . $msg . '</div>';
}

include "inc/footer-min.php";

?>
