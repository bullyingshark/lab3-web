<?php

    include "../config/init.php";
	
	echo "<br> Sesid: ".$UserSes->getSessionId()."<br>";

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

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

    $news_title = Request::getHttpVar("news_title", "");
    $news_content = Request::getHttpVar("news_content", "");

    $msg = "";

    $newsModel = new NewsModel($db);
    $news_list = $newsModel->getListAllNews();

    // ACTION LIST
    // Edit - редактировать новость
    // Update - сохранить изменение новости
    // Add - добавить новость
    // Del - удалить новость

    // Список VIEW
    // NewsList - список всех новостей
    // NewsEdit - форма редактирования новости
    // NewsAdd - форма добавления новости

    switch($action)
    {
        case "Edit":
            $news_id = Request::getHttpVar("news_id", 0);
            $news_id0 = intval($news_id);
            if($news_id0 == 0)
                break; 

            $viewMode[] ="NewsList";
            $viewMode[] ="NewsEdit";

            $news_info = $newsModel->getNewsById($news_id);
            $news_title = $news_info['title'];
            $news_content = $news_info['textPub'];
            break;
        
        case "Del":
            $news_id = Request::getHttpVar("news_id", 0);
            $news_id0 = intval($news_id);
            if($news_id0 == 0)
                break; 

            $newsModel->deleteNews($news_id);
			header("Location: news.php");
            break;
        
        case "Update":
            $news_id = Request::getHttpVar("news_id", 0);
            $news_id0 = intval($news_id);
            if($news_id0 == 0)
                break; 

            if (empty($news_title) || empty($news_content)) {
                $msg = "All fields are required.";
                $viewMode[] = "NewsEdit";
                break;
            }

            if($newsModel->updateInfoNews($news_id, $news_title, $news_content))
            {
                $news_title = "";
                $news_content = "";
            }
			header("Location: news.php");
            break;
        
        case "Add":
            if($newsModel->checkNewsTitleExistInBase($news_title))
            {
                $msg = "News with this title is already in the database";
                break;
            }

            if($newsModel->checkNewsContentExistInBase($news_content))
            {
                $msg = "News with such content is already in the database";
                break;
            }

            if($newsModel->addNewNews($news_title, $news_content))
            {
                $news_title = "";
                $news_content = "";
            }
			header("Location: news.php");
            break;

    }

    if(count($viewMode) == 0)
    {
        $viewMode[] = "NewsList";
        $viewMode[] = "NewsAdd";

    }

    ////////////////////////////////////////////////////////////////////////////

    include "inc/adm-header-min.php";


    // var_dump($viewMode);

    for($iv = 0; $iv < count($viewMode); $iv++)
    {
		//$view_file = "views/news/".$viewMode[$iv].".php";
		//if( file_exists($view_file) )
		//{
		//	include $view_file;
		//}
		
		
        if($viewMode[$iv] == "NewsEdit")
        {   
			include "views/news/newsEdit.php";
			/*
            ?>
            <br /><br />
            <h3 style="text-align: center;">Редагувати новину</h3>
            <div class="form-container">
                <form action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
                    <input type="hidden" name="action" value="Update">
                    <input type="hidden" name="news_id" value="<?=$news_id;?>">
                        <div class="form-row">
                            <span>Заголовок:</span>
                            <input type="text" name="news_title" value="<?=$news_title;?>"/>
                        </div>
                        <div class="form-row">
                            <span>Текст:</span>
                            <input type="text" name="news_content" value="<?=$news_content;?>"/>
                        </div>
                        <div class="button">
                            <input type="submit" value="Зберегти"/>
                        </div>
                </form>
            </div>
            <?php
			*/
        }

        else if($viewMode[$iv] == "NewsList")
        {  
			include "views/news/newsList.php";
			/*
           ?>
           <br /><br />
           <h3 style="text-align: center;">Перелік новин</h3>
           <table border="1" style="text-align: center; margin: 0 auto; ">
                <tr>
                    <th>Ідентифікатор</th>
                    <th>Заголовок</th>
                    <th>Текст</th>
                    <th>Операція</th>
                </tr>
                
                <?php foreach ($news_list as $news): ?>
                    <tr>
                        <td><?php echo $news['id']; ?></td>
                        <td><?php echo $news['title']; ?></td>
                        <td><?php echo $news['content']; ?></td>
                        <td style="display: flex;">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <input type="hidden" name="action" value="Edit">
                            <input type="hidden" name="news_id" value="<?php echo $news['id']; ?>">
                            <input type="submit" value="Редагувати">
                        </form>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <input type="hidden" name="action" value="Del">
                            <input type="hidden" name="news_id" value="<?php echo $news['id']; ?>">
                            <input type="submit" value="Видалити">
                        </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
           <?php
		   */
        }

        else if($viewMode[$iv] == "NewsAdd")
        {   
			include "views/news/newsAdd.php";
			/*
            ?>
            <br /><br />
            <h3 style="text-align: center;">Додати новину</h3>
            <div class="form-container">
                <form action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
                    <input type="hidden" name="action" value="Add">
                    <input type="hidden" name="news_id" value="<?=$news_id;?>">
                        <div class="form-row">
                            <span>Заголовок:</span>
                            <input type="text" name="news_title" value="<?=$news_title;?>"/>
                        </div>
                        <div class="form-row">
                            <span>Текст:</span>
                            <input type="text" name="news_content" value="<?=$news_content;?>"/>
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


