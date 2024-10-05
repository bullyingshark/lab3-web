<?php
            ?>
            <br /><br />
            <h3 style="text-align: center;">Редагувати інформацію про адміністратора</h3>
            <div class="form-container">
                <form action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
                    <input type="hidden" name="action" value="Update">
                    <input type="hidden" name="uid" value="<?=$uid;?>">
                        <div class="form-row">
                            <span>Логін:</span>
                            <input type="text" name="ulogin" value="<?=$ulogin;?>" required/>
                        </div>
                        <div class="form-row">
                            <span>Пароль:</span>
                            <input type="password" name="upass" <?php echo isset($uinfo) ? '' : 'required'; ?>/>
                        </div>
                        <div class="form-row">
                            <span>Рівень доступу:</span>
                            <input type="text" name="ulevel" value="<?=$ulevel;?>" required/>
                        </div>
                            <div class="button">
                            <input type="submit" value="Зберегти"/>
                        </div>
                </form>
            </div>
