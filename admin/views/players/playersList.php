<?php

?>
<br /><br />
<h3 style="text-align: center;">Перелік гравців</h3>
<table border="1" style="text-align: center; margin: 0 auto; ">
    <tr>
        <th>Ідентифікатор</th>
        <th>Ім'я</th>
        <th>Категорія</th>
        <th>Зарплата</th>
        <th>Номер</th>
        <th>Рік</th>
        <th>Зображення</th>
        <th>Операція</th>
    </tr>
    
    <?php foreach ($players_list as $player): ?>
        <tr>
            <td><?php echo $player['id']; ?></td>
            <td><?php echo $player['name']; ?></td>
            <td><?php echo $player['category']; ?></td>
            <td><?php echo $player['salary']; ?></td>
            <td><?php echo $player['number']; ?></td>
            <td><?php echo $player['year']; ?></td>
            <td><img src="<?php echo $player['image']; ?>" alt="<?php echo $player['name']; ?>" width="50" height="50"></td>
            <td style="display: flex;">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <input type="hidden" name="action" value="Edit">
                    <input type="hidden" name="player_id" value="<?php echo $player['id']; ?>">
                    <input type="submit" value="Редагувати">
                </form>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <input type="hidden" name="action" value="Del">
                    <input type="hidden" name="player_id" value="<?php echo $player['id']; ?>">
                    <input type="submit" value="Видалити">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
