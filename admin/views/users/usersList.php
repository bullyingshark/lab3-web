<?php
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
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['role']; ?></td>
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
