<?php
	session_start();
	
	if(!isset($_SESSION['zalogowany']))
	{
		header ('Location: index.php');
		exit();
	}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Zostań inżynierem!</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>

<?php

	require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

	$polskie_znaki ="SET NAMES utf8";
	$wysylanie = $polaczenie->query($polskie_znaki);

		if($polaczenie->connect_errno!=0)
		{
			echo "Error: ".$polaczenie->connect_errno;
		}
		else
		{	
		
		$rezultat = $polaczenie->query(
		"SELECT * FROM `users` ORDER BY `users`.`ratio` DESC LIMIT 10");

		?>
		<div class="container" id="ranking">
		<?php
				
				echo "<table>
				<caption>TOP 10 w % poprawnych odpowiedzi</caption>";
				echo "<tr><th>Miejsce</th><th>Nick</th><th>Wynik</th></tr>";
				
				$licznik = 1;
				
				while($wiersz=$rezultat->fetch_array())
				{
					echo "<tr><th>$licznik</th><td>".$wiersz['nick']."</td><td>".$wiersz['ratio']."%</td></tr>";
					$licznik++;
				}
				
				$licznik = 1;
				
				echo "</table>";

		?>
		</div>
		
		<div class="container" id="ranking">

		<?php
				
		$rezultat = $polaczenie->query(
		"SELECT * FROM `users` ORDER BY `users`.`correct` DESC LIMIT 10");
				
				echo "<table>
				<caption>TOP 10 w liczbie poprawnych odpowiedzi</caption>";
				echo "<tr><th>Miejsce</th><th>Nick</th><th>Punkty</th></tr>";
				
				$licznik = 1;
				
				while($wiersz=$rezultat->fetch_array())
				{
					echo "<tr><th>$licznik</th><td>".$wiersz['nick']."</td><td>".$wiersz['correct']."</td></tr>";
					$licznik++;
				}
				
				$licznik = 1;
				
				echo "</table>";
				
		$polaczenie->close();
		}
		
?>
		</div>
		<div class="container">
			<form action="gra.php" method="post">
				<input type="submit" value="Wróć do swojego panelu" />
			</form>
		</div>




</body>
</html>