<?php
include "../inc/header.php";
?>
<div class="body-center">
	<div class="div-admin">
		<a href="../admin/auth.php">Auth For Admin</a>
	</div>
	

	<div class="div-xml">
	<?php
	$xmlFile = 'players.xml';
	$dom = new DOMDocument;
	$dom->load($xmlFile);

	$players = $dom->getElementsByTagName('player');

	foreach ($players as $player) {
	    echo '<div class="player">';

		    echo '<img src="' . getValueByTagName($player, 'image') . '" alt="' . getValueByTagName($player, 'name') . '">';

		    echo '<h3 id="xml-h3">' . getValueByTagName($player, 'name') . '</h3>';
		    echo '<p><strong>Salary:</strong> $' . getValueByTagName($player, 'salary') . '</p>';
		    echo '<p><strong>Year:</strong> ' . getValueByTagName($player, 'year') . '</p>';

		    echo '<p><strong>Parameter:</strong></p>';

		    $parameters = $player->getElementsByTagName('parameter');
		    foreach ($parameters as $parameter) {
		        echo $parameter->nodeValue . '; ';
		    }

	    echo '</div>';
	}

	function getValueByTagName($element, $tagName) {
	    return $element->getElementsByTagName($tagName)->item(0)->nodeValue;
	}
	?>
</div>
</div>
<?php
include "../inc/footer.php";
?>