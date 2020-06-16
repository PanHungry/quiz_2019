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

	$_SESSION['ile_pytan'] = 0;
	$_SESSION['pkt_sesja'] = 0;
	
	$zadane_pytania_id[20] = array();
	$poprawnosc_odpowiedzi[20] = array();
	$twoja_odpowiedz[20] = array();
	$tablica_randomow[20] = array();
	
	$_SESSION['id_pytan'] = $zadane_pytania_id;
	$_SESSION['poprawnosc'] = $poprawnosc_odpowiedzi;
	$_SESSION['twoja_odp'] = $twoja_odpowiedz;
	$_SESSION['random'] = $tablica_randomow;

	echo "<h2>Witaj ".$_SESSION['user'].'!</h2>';

	echo "<b>Twoje dotychczasowe punkty:</b> ".$_SESSION['pkt_calosc']."<br /><br />";
	echo "<b>Twój średni wynik:</b> ".round($_SESSION['skutecznosc'], 0)."%<br /><br />";

?>

<form action="quiz.php">
    <input type="submit" value="Rozpocznij grę!" />
</form>

<form action="ranking.php">
    <input type="submit" value="Sprawdź ranking inżynierów!" />
</form>

<div id="logout" class="container">
	<a href="logout.php">Wyloguj się!</a>
</div>

</body>
</html>