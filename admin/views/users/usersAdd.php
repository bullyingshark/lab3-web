<?php
            ?>
            <br /><br />
            <h3 style="text-align: center;">Додати адміністратора</h3>
            <div class="form-container">
                <form action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
                    <input type="hidden" name="action" value="Add">
                    <div class="form-row">
                        <span>Логін:</span>
                        <input type="text" name="username" required/>
                    </div>
                    <div class="form-row">
                        <span>Пароль:</span>
                        <input type="password" name="upass" required/>
                    </div>
                    <div class="form-row">
                        <span>Рівень доступу:</span>
                        <input type="text" name="role" required/>
                    </div>
                    <div class="button">
                        <input type="submit" value="Зберегти"/>
                    </div>
                </form>
            </div>
       