<?php

?>
            <br /><br />
            <h3 style="text-align: center;">Додати новину</h3>
            <div class="form-container">
                <form action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
                    <input type="hidden" name="action" value="Add">
                    <input type="hidden" name="news_id" value="<?=$news_id;?>">
                        <div class="form-row">
                            <span>Заголовок:</span>
                            <input type="text" name="news_title" value="<?=$news_title;?>" required/>
                        </div>
                        <div class="form-row">
                            <span>Текст:</span>
                            <input type="text" name="news_content" value="<?=$news_content;?>" required/>
                        </div>
                        <div class="button">
                            <input type="submit" value="Зберегти"/>
                        </div>
                </form>
            </div>
