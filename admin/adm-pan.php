<?php
include "../config/init.php"; 

    if(!$UserSes->isLogged())
    {
        header("Location: auth.php");
        exit();
    }

    if(isset($_POST['logout'])) 
    {
        $UserSes->logout();
        unset($_SESSION['user_session']);
        header("Location: auth.php");
        exit();
    }

    include "inc/adm-header-min.php";

    include "inc/footer-min.php";


?>

