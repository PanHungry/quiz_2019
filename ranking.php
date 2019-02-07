<?php
	session_start();
	
	if(!isset($_SESSION['zalogowany']))
	{
		header ('Location: index.php');
		exit();
	}
?>

<DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Become an engineer!</title>
</head>

<body bgcolor="#BBBBBB">

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
		"SELECT * FROM `uzytkownicy` ORDER BY `uzytkownicy`.`ratio` DESC LIMIT 10");
				
				echo "<table border='1' cellpadding='7' cellspacing='0'>
				<caption align='top'><b>TOP 10 w % poprawnych odpowiedzi</b></caption>";
				echo "<tr><th><b>Miejsce</b></th><th><b>Nick</b></th><th><b>Wynik</b></th></tr>";
				
				$licznik = 1;
				
				while($wiersz=$rezultat->fetch_array())
				{
					echo "<tr align='middle'><th>$licznik</th><td>".$wiersz['user']."</td><td>".$wiersz['ratio']."%</td></tr>";
					$licznik++;
				}
				
				$licznik = 1;
				
				echo "</table><br />";
				
		$rezultat = $polaczenie->query(
		"SELECT * FROM `uzytkownicy` ORDER BY `uzytkownicy`.`punkty_calosc` DESC LIMIT 10");
				
				echo "<table border='1' cellpadding='7' cellspacing='0'>
				<caption align='top'><b>TOP 10 w liczbie poprawnych odpowiedzi</b></caption>";
				echo "<tr><th><b>Miejsce</b></th><th><b>Nick</b></th><th><b>Punkty</b></th></tr>";
				
				$licznik = 1;
				
				while($wiersz=$rezultat->fetch_array())
				{
					echo "<tr align='middle'><th>$licznik</th><td>".$wiersz['user']."</td><td>".$wiersz['punkty_calosc']."</td></tr>";
					$licznik++;
				}
				
				$licznik = 1;
				
				echo "</table><br />";
				
		$polaczenie->close();
		}
		
?>

<form action="gra.php" method="post">
<input type="submit" value="Wróć do swojego panelu" />
</form>


</body>
</html>