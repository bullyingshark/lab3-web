<?php

// Функция для получения информации о файлах и каталогах в текущем каталоге
function getDirectoryContents($directory)
{
    $result = array();

    // Проверка наличия каталога
    if (is_dir($directory)) {
        $files = scandir($directory);

        foreach ($files as $file) {
            // Исключаем текущий и родительский каталоги
            if ($file != "." && $file != "..") {
                $filePath = $directory . '/' . $file;

                // Проверка наличия опасных символов в пути
                if (strpos($file, '..') === false) {
                    $info = array(
                        'name' => $file,
                        'type' => is_dir($filePath) ? 'dir' : 'file',
                        'size' => formatSize(filesize($filePath)),
                        'created' => date("Y-m-d H:i:s", filectime($filePath)),
                        'action' => '<a href="?file=' . $file . '">OPEN</a>'
                    );

                    $result[] = $info;
                }
            }
        }
    }

    return $result;
}

// Функция для форматирования размера файла
function formatSize($size)
{
    $units = array('B', 'KB', 'MB', 'GB');
    $i = 0;

    while ($size >= 1024 && $i < count($units) - 1) {
        $size /= 1024;
        $i++;
    }

    return round($size, 2) . ' ' . $units[$i];
}

// Определение текущего каталога
$currentDirectory = __DIR__;

// Проверка, был ли передан параметр для открытия конкретного файла или каталога
if (isset($_GET['file'])) {
    $requestedFile = $_GET['file'];
    $currentDirectory .= '/' . $requestedFile;

    // Защита от возможных атак типа "../../../../"
    if (strpos($requestedFile, '..') === false) {
        $contents = getDirectoryContents($currentDirectory);
    } else {
        echo "The forbidden path!";
        exit;
    }
} else {
    $orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : 'name';

    // Получение параметра направления сортировки из GET-запроса
    $orderDir = isset($_GET['orderDir']) ? $_GET['orderDir'] : 'asc';

    // Получение списка файлов и каталогов в текущем каталоге
    $contents = getDirectoryContents($currentDirectory);

    // Сортировка массива в соответствии с выбранным критерием и направлением
    usort($contents, function ($a, $b) use ($orderBy, $orderDir) {
        if ($orderBy === 'name') {
            return $orderDir === 'asc' ? strcmp($a['name'], $b['name']) : strcmp($b['name'], $a['name']);
        } elseif ($orderBy === 'size') {
            return $orderDir === 'asc' ? $a['size'] <=> $b['size'] : $b['size'] <=> $a['size'];
        } elseif ($orderBy === 'created') {
            return $orderDir === 'asc' ? strtotime($a['created']) <=> strtotime($b['created']) :
                strtotime($b['created']) <=> strtotime($a['created']);
        } else {
            return 0;
        }
    });
}



	include "../inc/header.php";
?>
			<div class="body-center">
			<div class="file-manager">
				<h3>Season File Manager</h3>

			    <div class="sort-menu">
                    
			        <a href="?orderBy=name&orderDir=asc">Name &#8593;</a> |
			        <a href="?orderBy=name&orderDir=desc">&#8595;</a> |
			        <a href="?orderBy=size&orderDir=asc">Size &#8593;</a> |
			        <a href="?orderBy=size&orderDir=desc">&#8595;</a> |
			        <a href="?orderBy=created&orderDir=asc">Creation date &#8593;</a> |
			        <a href="?orderBy=created&orderDir=desc">&#8595;</a>
                    
			    </div>

				<table>
					<tr>
            			<th>Name file</th>
            			<th>Type</th>
            			<th>Size</th>
            			<th>Creation date</th>
            			<th>Action</th>
        			</tr>

	        		<?php foreach ($contents as $item): ?>
	            		<tr class="tr-filemanag">
	                		<td><?php echo $item['name']; ?></td>
	                		<td><?php echo $item['type']; ?></td>
	                		<td><?php echo $item['size']; ?></td>
	                		<td><?php echo $item['created']; ?></td>
	                		<td class="link-act"><?php echo $item['action']; ?></td>
	            		</tr>
	        		<?php endforeach; ?>

				</table>

			</div>
			</div>

<?php
	include "../inc/footer.php";
?>