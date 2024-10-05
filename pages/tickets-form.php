<?php

function getVar($name, $def = "", $type = null)
{
	$val = $def;
	
	if( isset($_POST[$name]) ) 
		$val = $_POST[$name];

	$val = str_replace("\"", "&quot;", $val);
	if( $type  != null )
	{
		switch($type)
		{
			case "int":
				$val = intval($val);
				break;
		}
	}
	return $val;
}

$action = getVar("action");
$name = getVar("name");
$gender = getVar("rb", "m");
$day = getVar("date");
$month = getVar("month");
$year = getVar("year");
$errorMessage = '';
	
if( $action == "checkBirthday" )
{
    $currentDate = new DateTime();
    $currentYear = $currentDate->format("Y");
    $currentMonth = $currentDate->format("n");
    $currentDay = $currentDate->format("j");

    if (!is_numeric($day) || !is_numeric($month) || !is_numeric($year)) {
        $errorMessage = "Please enter valid numeric values for the date!";
    } else {
        $ageYear = $currentYear - $year;

        if (($currentMonth < $month) || ($currentMonth == $month && $currentDay <= $day)) {
            $ageYear--;
        }

        if (($gender == "m" && $ageYear >= 21) || ($gender == "f" && $ageYear >= 18)) {
            $errorMessage = "Registration successful!";
        } else {
            $errorMessage = "You can't register! You're under a certain age!";
        }
    }
}
//var_dump($errorMessage);
	include "../inc/header.php";
?>
			<div class="body-center">
				<div class="div-form">
					<h3>To order tickets, please fill in the form</h3>
					<form id="form" action="tickets-form.php" method="POST">
						<input type="hidden" name="action" value="checkBirthday">
						<div class="form-boxes">
							<div>
								Put name&#58;&nbsp;<input id="name" type="text" name="name" value="<?=$name;?>" placeholder="name">
							</div>
							<div>
								Identify gender&#58;
								<input type="radio" name="rb" value="m" <?=($gender == "m" ? " checked" : "");?>>
								<label for="pm">male</label>
								&nbsp;
								<input type="radio" name="rb" value="f" <?=($gender == "f" ? " checked" : "");?>>
								<label for="pf">female</label>
							</div>
							<div class="div-date">
								Give date of birth&#58;&nbsp;
								<input id="dd" type="int" name="date" value="<?=$day;?>" placeholder="dd">
								<input id="mm" type="int" name="month" value="<?=$month;?>" placeholder="mm">
								<input id="yyyy" type="int" name="year" value="<?=$year;?>" placeholder="yyyy">
							</div>
							<div><input type="submit" value="Order" id="submit"></div>
						</div>
					</form>
					<div id="errorMessage"><?php echo $errorMessage; ?></div>
				</div>
			</div>
<?php
	include "../inc/footer.php";
?>