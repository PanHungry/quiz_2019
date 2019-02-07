<?php 

session_start();

	if(isset($_POST['ans']))
	{
		$answer = $_POST['ans'];  
		$_SESSION['twoja_odp'][$_SESSION['ile_pytan']] = $_POST['ans'];
		
		if ($answer == $_SESSION['prawidlowa']) 
		{
			$_SESSION['pkt_sesja']++;
			$_SESSION['poprawnosc'][$_SESSION['ile_pytan']] = 1;
		}
		else
		{
			$_SESSION['poprawnosc'][$_SESSION['ile_pytan']] = 0;
		}				
		unset($_POST['ans']);
	}
	else
	{
		$_SESSION['twoja_odp'][$_SESSION['ile_pytan']] = "brak_odp";
		$_SESSION['poprawnosc'][$_SESSION['ile_pytan']] = 0;
	}
	
	$_SESSION['id_pytan'][$_SESSION['ile_pytan']] = $_SESSION['id_pytania'];

	
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
	
?>