<?php

	session_start();
	
	if((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		header ('Location: index.php');
		exit();
	}
	

	require_once "connect.php";
	
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{
		$login = $_POST['login'];
		$haslo = $_POST['haslo'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		
		
		if ($rezultat = @$polaczenie->query(
		sprintf("SELECT * FROM users WHERE nick='%s'",
		mysqli_real_escape_string($polaczenie,$login))))
		{
			$ile_userow = $rezultat->num_rows;
			if($ile_userow>0)
			{
				$wiersz=$rezultat->fetch_assoc();
				
				if(password_verify($haslo, $wiersz['password']))
				{				
					$_SESSION['zalogowany'] = true;
					$_SESSION['id'] = $wiersz['id'];
					$_SESSION['user'] = $wiersz['nick'];
					$_SESSION['email']=$wiersz['email'];
					$_SESSION['pkt_calosc']=$wiersz['correct'];
					$_SESSION['pytania_calosc']=$wiersz['questions'];
					$_SESSION['skutecznosc']=$wiersz['ratio'];
					
					
					unset($_SESSION['blad']);
					$polaczenie->close();
					$rezultat->free_result();
					header('Location: gra.php');
				}
				else 
				{
		
				$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!!!</span>';
				$polaczenie->close();
				header('Location: index.php');
				
				}
				
			} else {
				
							
				$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło! :(</span>';
				$polaczenie->close();
				header('Location: index.php');
				
			}
			
		}		
		
	}
	


	
?>