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

	<div class="container">
		<div id="summary">

			<?php

				require_once "connect.php";
		
				echo "<h3>Prawidłowych odpowiedzi: ".$_SESSION['pkt_sesja']."/20</h3>";

				$win_ratio = ($_SESSION['pkt_sesja']/20)*100;

				echo "<h3>Wynik: ";

					if($win_ratio>=50)
					{
						echo $win_ratio."% "."<span style='color:lime;'>Zdane!</span></h3>";
					}
					else
					{
						echo $win_ratio."%"."<h3><span style='color:red;'>Niezdane!</span></h3>";
					}

			?>
		</div>
	</div>
	
	<div class="container">
		<div id="answers">

			<?php

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

	$polskie_znaki ="SET NAMES utf8";
	$wysylanie = $polaczenie->query($polskie_znaki);
	$id_user = $_SESSION['id'];

		if($polaczenie->connect_errno!=0)
		{
			echo "Error: ".$polaczenie->connect_errno;
		}
		else
		{	

//////////////////////////////// WYŚWIETLANIE PRAWIDŁOWYCH ODP
		
		for( $x = 0; $x <= 19; $x++ )
			{
		
		$nr_pytania = $x+1;
		$id_zadanego_pytania = $_SESSION['id_pytan'][$x];
		
		$rezultat = $polaczenie->query(
		"SELECT * FROM pytania WHERE id = '$id_zadanego_pytania'");
		
		$wiersz=$rezultat->fetch_assoc();		
		
		$poprawna_odpowiedz = $wiersz['answer'];
				
		echo "<b>Pytanie nr ".$nr_pytania.": </b>".$wiersz['tresc']."<br />";
		
		////////////
		
		$twoja_odp = $_SESSION['twoja_odp'][$x];
		
		echo "<b>Twoja odpowiedź: </b>";
		
		switch ($twoja_odp) 
			{
			
			case "a":
			echo $wiersz['odpa']."<br />";
			break;
			
			case "b":
			echo $wiersz['odpb']."<br />";
			break;
			
			case "c":
			echo $wiersz['odpc']."<br />";
			break;
			
			case "d":
			echo $wiersz['odpd']."<br />";
			break;
			
			case "brak_odp":
			echo '<span style="color:red;">Nie udzielono odpowiedzi!</span>';
			break;
			}
		
		///////////
		
				
		if ($twoja_odp!="brak_odp")
			{
				$dobrze_zle = '<span style="color:lime;">dobra!</span>'."<br />";
		
				if ($_SESSION['poprawnosc'][$x]==0)
				{
					$dobrze_zle = '<span style="color:red;">zła!</span>';
				}
		
				echo "<b>Twoja odpowiedź była ".$dobrze_zle." </b><br />";
				
			}
			else
			{
			echo "<br />";
			}
			
		/////////////////

		if ($_SESSION['poprawnosc'][$x]==0)
		{
		echo "<b>Prawidłowa odpowiedź: </b>";
		
			switch ($poprawna_odpowiedz) 
			{
			
			case "a":
			echo $wiersz['odpa']."<br /><br />";
			break;
			
			case "b":
			echo $wiersz['odpb']."<br /><br />";
			break;
			
			case "c":
			echo $wiersz['odpc']."<br /><br />";
			break;
			
			case "d":
			echo $wiersz['odpd']."<br /><br />";
			break;
			}
		}
		
		/////////
		
		
			
		}
		
		
//////////////////////////////////////////// PODLICZANIE PUNKTÓW
		if($_SESSION['licz']==1)
		{

$_SESSION['pkt_calosc'] = $_SESSION['pkt_sesja'] + $_SESSION['pkt_calosc'];
$aktualne_punkty = $_SESSION['pkt_calosc'];
$_SESSION['pytania_calosc'] = $_SESSION['pytania_calosc'] + 20;
$wszystkie_punkty = $_SESSION['pytania_calosc'];
$skutecznosc = ($aktualne_punkty / $wszystkie_punkty) * 100;
$_SESSION ['skutecznosc'] = $skutecznosc;

	//echo " ID usera ".$id_user." aktualne ".$aktualne_punkty."  wszystkie ".$wszystkie_punkty."  ratio".$skutecznosc."<br /><br />";

$_SESSION['ile_pytan'] = 0;
$_SESSION['pkt_sesja'] = 0;

		

			$polaczenie->query(
			"UPDATE `users` SET `correct` = '$aktualne_punkty' WHERE `users`.`id` = '$id_user'");
			
			$polaczenie->query(
			"UPDATE `users` SET `questions` = '$wszystkie_punkty' WHERE `users`.`id` = '$id_user'");
			
			$polaczenie->query(
			"UPDATE `users` SET `ratio` = '$skutecznosc' WHERE `users`.`id` = '$id_user'");

			$_SESSION['licz']=0;

		}
			
			$polaczenie->close();
			
	}
?>

	</div> 
</div>

<form action="gra.php" method="post">
	<input type="submit" value="Wróć do swojego panelu" />
</form>


</body>
</html>