<?php

    include "../config/init.php";
	
	echo "<br> Sesid: ".$UserSes->getSessionId()."<br>";

	/*
    if(isset($_SESSION['user_session'])) 
    {
        $UserSes = unserialize($_SESSION['user_session']);
    } 

    else 
    {
        
        header("Location: auth.php");
        exit();
    }
	*/

    if(!$UserSes->isLogged())
    {
        header("Location: auth.php");
        exit();
    }

    $action = Request::getHttpVar("action", "");
    $viewMode = Array();

    $ulogin = Request::getHttpVar("username", "");
    $upass = Request::getHttpVar("password", "");
    $ulevel = Request::getHttpVar("role", "");

    $msg = "";

    $userModel = new UserModel($db);
    $ulist = $userModel->getListAllUsers();

    // ACTION LIST
    // Edit - редактировать пользователя
    // Update - сохранить изменение пользователя
    // Add - добавить пользователя
    // Del - удалить пользователя

    // Список VIEW
    // UserList - список всех пользователей
    // UserEdit - форма редактирования пользователя
    // UserAdd - форма добавления пользователя

    switch($action)
    {
        case "Edit":
            $uid = Request::getHttpVar("uid", 0);
            $uid0 = intval($uid);
            if($uid0 == 0)
                break; 

            $viewMode[] ="UserList";
            $viewMode[] ="UserEdit";

            $uinfo = $userModel->getUserById($uid);
            $ulogin = $uinfo['username'];
            $upass = $uinfo['password'];
            $ulevel = $uinfo['role'];
            break;
        
        case "Del":
            $uid = Request::getHttpVar("uid", 0);
            $uid0 = intval($uid);
            if($uid0 == 0)
                break;

            $userModel->deleteUser($uid);
            break;
        
        case "Update":
            $uid = Request::getHttpVar("uid", 0);
            $uid0 = intval($uid);
            if($uid0 == 0)
                break;

            // if (empty($ulogin) || empty($ulevel)) {
            //     $msg = "All fields are required.";
            //     $viewMode[] = "UserEdit";
            //     break;
            // }

            if($userModel->updateInfoUser($uid, $ulogin, $upass, $ulevel))
            {
                $ulogin = "";
                $upass = "";
                $ulevel = "";
            }
			header("Location: users.php");
            exit();

            break;
        
        case "Add":
            if($userModel->checkLoginExistInBase($ulogin))
            {
                $msg = "A user with this login already exists in the database";
                break;
            }

            if($userModel->addNewUser($ulogin, $upass, $ulevel))
            {
                $ulogin = "";
                $upass = "";
                $ulevel = "";
            }

            break;

    }

    if(count($viewMode) == 0)
    {
        $viewMode[] = "UserList";
        $viewMode[] = "UserAdd";

    }

    ////////////////////////////////////////////////////////////////////////////

    include "inc/adm-header-min.php";


    // var_dump($viewMode);

    for($iv = 0; $iv < count($viewMode); $iv++)
    {
        if($viewMode[$iv] == "UserEdit")
        {   

            include "views/users/usersEdit.php";
            /*
            ?>
            <br /><br />
            <h3 style="text-align: center;">Редагувати інформацію про адміністратора</h3>
            <div class="form-container">
                <form action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
                    <input type="hidden" name="action" value="Update">
                    <input type="hidden" name="uid" value="<?=$uid;?>">
                        <div class="form-row">
                            <span>Логін:</span>
                            <input type="text" name="ulogin" value="<?=$ulogin;?>"/>
                        </div>
                        <div class="form-row">
                            <span>Пароль:</span>
                            <input type="text" name="upass" value=""/>
                        </div>
                        <div class="form-row">
                            <span>Рівень доступу:</span>
                            <input type="text" name="ulevel" value="<?=$ulevel;?>"/>
                        </div>
                            <div class="button">
                            <input type="submit" value="Зберегти"/>
                        </div>
                </form>
            </div>
            <?php
            */
        }

        else if($viewMode[$iv] == "UserList")
        {  


            include "views/users/usersList.php";
            /*
           ?>
           <br /><br />
           <h3 style="text-align: center;">Перелік адміністраторів у базі</h3>
           <table border="1" style="text-align: center; margin: 0 auto; ">
                <tr>
                    <th>Ідентифікатор</th>
                    <th>Логін</th>
                    <th>Рівень доступу</th>
                    <th>Операція</th>
                </tr>
                
                <?php foreach ($ulist as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['login']; ?></td>
                        <td><?php echo $user['level']; ?></td>
                        <td style="display: flex;">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <input type="hidden" name="action" value="Edit">
                            <input type="hidden" name="uid" value="<?php echo $user['id']; ?>">
                            <input type="submit" value="Редагувати">
                        </form>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <input type="hidden" name="action" value="Del">
                            <input type="hidden" name="uid" value="<?php echo $user['id']; ?>">
                            <input type="submit" value="Видалити">
                        </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
           <?php
           */
        }

        else if($viewMode[$iv] == "UserAdd")
        {   
            include "views/users/usersAdd.php";

            /*
            ?>
            <br /><br />
            <h3 style="text-align: center;">Додати адміністратора</h3>
            <div class="form-container">
                <form action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
                    <input type="hidden" name="action" value="Add">
                    <input type="hidden" name="uid" value="<?=$uid;?>">
                        <div class="form-row">
                            <span>Логін:</span>
                            <input type="text" name="ulogin" value="<?=$ulogin;?>"/>
                        </div>
                        <div class="form-row">
                            <span>Пароль:</span>
                            <input type="text" name="upass" value="<?=$upass;?>"/>
                        </div>
                        <div class="form-row">
                            <span>Рівень доступу:</span>
                            <input type="text" name="ulevel" value="<?=$ulevel;?>"/>
                        </div>
                            <div class="button">
                            <input type="submit" value="Зберегти"/>
                        </div>
                </form>
            </div>
            <?php
            */
        }
    }

    if($msg != "")
    {
        echo '<div style="color: red; text-align:center;">'.$msg.'</div>';
    }

    include "inc/footer-min.php";


