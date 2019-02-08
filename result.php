<?php 

session_start();

for ($i=0; $i<20; $i++)
{
	if(isset($_POST['ans'.$i]))
	{
		$answer = $_POST['ans'.$i];

		/*if($answer != ("a" AND "b" AND "c" AND "d"))
		{
			$_SESSION['twoja_odp'][$i] = "brak_odp";
		}
		else 
		{*/
			$_SESSION['twoja_odp'][$i] = $_POST['ans'.$i];
	}
	else
	{
		$_SESSION['twoja_odp'][$i] = "brak_odp";
	}

		if ($answer == $_SESSION['prawidlowa'][$i]) 
		{
			$_SESSION['pkt_sesja']++;
			$_SESSION['poprawnosc'][$i] = 1;
		}
		else
		{
			$_SESSION['poprawnosc'][$i] = 0;
		}				
		//unset($_POST['ans']);
	//}
	//else
	//{
		//$_SESSION['twoja_odp'][$_SESSION['ile_pytan']] = "brak_odp";
		//$_SESSION['poprawnosc'][$_SESSION['ile_pytan']] = 0;
	//}
	$answer = "clear";
}
	
	//$_SESSION['id_pytan'][$_SESSION['ile_pytan']] = $_SESSION['id_pytania'];

	$_SESSION['licz'] = 1;

	header('Location: end.php');
	exit();

	/*
	if($_SESSION['ile_pytan'] == 19)
	{
		$_SESSION['ile_pytan']++;
		header('Location: end.php');
		exit();
	}
	else
	{
		
	//$_SESSION['id_pytan'][$_SESSION['ile_pytan']] = $_SESSION['id_pytania'];		
	$_SESSION['ile_pytan']++;
	
	header('Location: quiz.php');
	exit();
	}
	*/
?>