<?php

$player_name = '';
$category = '';
$salary = '';
$number = '';
$year = '';
$image = '';

?>
<br /><br />
<h3 style="text-align: center;">Додати гравця</h3>
<div class="form-container">
    <form action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
        <input type="hidden" name="action" value="Add">
        <!-- Add more hidden input fields if needed -->
        <div class="form-row">
            <span>Ім'я гравця:</span>
            <input type="text" name="player_name" value="<?=$player_name;?>" required/>
        </div>
        <div class="form-row">
            <span>Категорія:</span>
            <input type="text" name="category" value="<?=$category;?>" required/>
        </div>
        <div class="form-row">
            <span>Зарплата:</span>
            <input type="text" name="salary" value="<?=$salary;?>" required/>
        </div>
        <div class="form-row">
            <span>Номер:</span>
            <input type="text" name="number" value="<?=$number;?>" required/>
        </div>
        <div class="form-row">
            <span>Рік:</span>
            <input type="text" name="year" value="<?=$year;?>" required/>
        </div>
        <div class="form-row">
            <span>Зображення:</span>
            <input type="text" name="image" value="<?=$image;?>" required/>
        </div>
        <div class="button">
            <input type="submit" value="Зберегти"/>
        </div>
    </form>
</div>
