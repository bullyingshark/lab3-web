<?php

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
                        <td><?php echo $news['textPub']; ?></td>
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