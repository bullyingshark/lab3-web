<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>hanzera</title>
	<link type="text/css" rel="stylesheet" href="../css/style.css">
	<link type="text/css" rel="stylesheet" href="css/adm-style.css">
	<link rel="stylesheet" href="../css/alt.css">
	<script src="../js/script.js"></script>
</head>
<body>
<div class="wrapper">	
	<header>
		<div class="anim-img-ball">
			<div class="bg-img">
				<a id="logo-link" href="../pages/index.php" title="Lithuanian-American Basketball Association">
					<img class="img-ball" name="ball" src="../img/logo-ball.png" alt="logo-ball">
				</a>
			</div>
		</div>
	</header>
	<main>
		<div>
			<menu class="menu">
				<a href="../pages/index.php"><span>HOME PAGE</span></a>
				<a href="#"><span>NEWS</span></a>
				<a href="../pages/players.php"><span>PLAYERS</span></a>
				<a href="../pages/season.php"><span>SEASON</span></a>
				<a href="../pages/statistics.php"><span>STATISTICS</span></a>
				<a href="../pages/sponsors.php"><span>SPONSORS</span></a>
				<a href="../pages/tickets-form.php"><span>TICKETS</span></a>
				<div><a href="#"><span></span></a></div>
			</menu>
		</div>
			<div class="body-colm">
			<?php echo $UserSes->isLogged() ? "Logged" : "Not" ?>
				<nav>
		            <ul>
		                <li><a href="users.php">Admins</a></li>
		                <li><a href="players.php">Players</a></li>
		                <li><a href="#">Site</a></li>
		                <li><a href="news.php">News</a></li>
		                <li>
		                    <form action="auth.php" method="POST">
		                        <input type="hidden" name="action" value="logout">
                <input type="submit" name="logout" value="Logout">
		                    </form>
		                </li>
		            </ul>
		        </nav>
			
