<?php session_start(); ?>

<?php
	/*if(!isset($_SESSION['zalogowany']))
	{
		header ('Location: index.php');
		exit();
	}*/
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
	
	// LOSOWANIE PYTANIA BEZ POWTÓRZEŃ
	
	$ile_pytan = 701; //z ilu pytan losujemy?
	$ile_wylosowac = 20; //ile pytan wylosowac?
	$pytania[20] = array();
	$ile_juz_wylosowano= $_SESSION['ile_pytan']; //zmienna pomocnicza
	//echo $ile_juz_wylosowano;

for ($i=0; $i<$ile_wylosowac; $i++)
 {
 	do
 	{
 		$liczba=rand(21,$ile_pytan); //losowanie w PHP
 		$losowanie_ok=true;

 		for ($j=0; $j<$i; $j++)
 		{
 			if ($liczba==$pytania[$j])
			{				
			$losowanie_ok=false;
			}
 		}

 		if ($losowanie_ok==true)
 		{
			 $pytania[$i] = $liczba; 
			 //echo "$pytania[$i] ";
 		}

 	} while($losowanie_ok!=true);
 }

//$id[20] = array();
$answer[20] = array();
$odpA[20] = array();
$odpB[20] = array();
$odpC[20] = array();
$odpD[20] = array();

for ($i=0; $i<$ile_wylosowac; $i++)
{

	$rezultat = @$polaczenie->query("SELECT * FROM pytania WHERE id='$pytania[$i]'");
	$ile_takich_pytan = $rezultat->num_rows;
	
		if($ile_takich_pytan>0)
		{
			$wiersz=$rezultat->fetch_assoc();
			
			$_SESSION['prawidlowa'][$i]= $wiersz['answer'];
			//$id[$i] = $wiersz['id'];
			$_SESSION['id_pytan'][$i] = $wiersz['id'];
			$answer[$i] = $wiersz['tresc'];
			$odpA[$i] = $wiersz['odpa'];
			$odpB[$i] = $wiersz['odpb'];
			$odpC[$i] = $wiersz['odpc'];
			$odpD[$i] = $wiersz['odpd'];


			
			//echo "Pytanie nr ".($_SESSION['ile_pytan']+1)."/20 <br />";
			
			//echo "Prawidlowa odpowiedź (roboczo): ".$_SESSION['prawidlowa'][$i]. "<br />";
			
			//echo "Prawidłowych odpowiedzi: ".$_SESSION['pkt_sesja']."/".$_SESSION['ile_pytan']."<br /><br />";
			
			//echo "ID pytania: ".$_SESSION['id_pytania'][$i]."<br /><br />";
			//echo "<b>".$wiersz['tresc']."</b>";
			
		}
}

			$polaczenie->close();

			?>
		

	<form action="result.php" method="post">

		<div id="quiz" class="container">

		<h2>Pamiętaj, że tylko jedna odpowiedź jest poprawna. Powodzenia!</h2>

			<?php for ($i=0; $i<$ile_wylosowac; $i++){ ?>

				<div class="question">

					<h4><?php echo "<b>".$answer[$i]."</b>"; ?> </h6>

					<label><input type="radio" name="ans<?php echo $i ?>" value="a" /> <?php echo $odpA[$i]; ?> </label>
					<label><input type="radio" name="ans<?php echo $i ?>" value="b" /> <?php echo $odpB[$i]; ?> </label>
					<label><input type="radio" name="ans<?php echo $i ?>" value="c" /> <?php echo $odpC[$i]; ?> </label>
					<label><input type="radio" name="ans<?php echo $i ?>" value="d" /> <?php echo $odpD[$i]; ?> </label>

				</div>


			<?php }?>

		<input type="submit" value="Gotowe!"/>

		</div>

	</form>

	<?php
	
	
}

?>


</body>

</html>