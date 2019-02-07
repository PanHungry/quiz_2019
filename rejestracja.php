<?php
	session_start();
	
	if (isset($_POST['email']))
	{
		//Udana walidacja? Załóżmy, że tak
		$wszystko_OK=true;
		
		// Sprawdzenie poprawnosci nickname
		$nick=$_POST['nick'];
		
		// Sprawdzenie długości nicku
		if ((strlen($nick)<3) || (strlen($nick)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków!";
		}
		
		if(ctype_alnum($nick)==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)!";
		}
		
		
		// Sprawdzenie poprawności e-mail
		$email=$_POST['email'];
		$emailB=filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$wszystko_OK=false;
			$_SESSION['e_email']="Podaj poprawy adres e-mail!";
		}
		
		// Sprawdź poprawność hasła
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		
		if((strlen($haslo1)<8) || (strlen($haslo1)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		if($haslo1!=$haslo2)
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Podane hasła nie są identyczne!";
		}
		
		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
		
		// Akceptacja regulaminu
		
		//if(!isset($_POST['regulamin']))
		//{
		//	$wszystko_OK=false;
		//	$_SESSION['e_regulamin']="Potwierdź akceptacje regulaminu!";
		//}
		
		// BOT or NOT?
		$sekret = "6LfDQn4UAAAAAFm3rl45bpr3fkXdDKXBzY5GrqBZ";
		
		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST[
		'g-recaptcha-response']);
		
		$odpowiedz = json_decode($sprawdz);
		
		if ($odpowiedz->success==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
		}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////		
		
		require_once "connect.php";
		
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//Czy email już istnieje?
				$rezultat= $polaczenie->query("SELECT id FROM users WHERE email='$email'");
				
				if(!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}
				
				//Czy nick już istnieje?
				$rezultat= $polaczenie->query("SELECT id FROM users WHERE nick='$nick'");
				
				if(!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_nickow = $rezultat->num_rows;
				if($ile_takich_nickow>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_nick']="Istnieje już gracz o takim nicku!";
				}
				
				//Dodanie do bazy
				
				if($wszystko_OK==true)
				{
					//Wszystko ok! Testy zaliczone!
					if($polaczenie->query("INSERT INTO users VALUES (NULL, '$nick', '$haslo_hash', '$email', 0, 0, 0)"))
					{
						$_SESSION['udanarejestracja']=true;
						header('Location: witamy.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}

				}
				$polaczenie->close();
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności!</span>';
			echo '<br />Informacja developerska: '.$e;
		}
		
		
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
		<script src='https://www.google.com/recaptcha/api.js'></script>
	</head>

	<body>


		<form method="post">

			<div class="container" id="registerForm">

				<label>Nickname:</label> <input type="text" name="nick" /><br />

	<?php
	
		if(isset($_SESSION['e_nick']))
		{
			echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
			unset($_SESSION['e_nick']);
		}
	
	?>

				<label>E-mail:</label><input type="text" name="email" /><br />

	<?php
	
		if(isset($_SESSION['e_email']))
		{
			echo '<div class="error">'.$_SESSION['e_email'].'</div>';
			unset($_SESSION['e_email']);
		}
	
	?>

				<label>Twoje hasło:</label><input type="password" name="haslo1" /><br />

	<?php
	
		if(isset($_SESSION['e_haslo']))
		{
			echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
			unset($_SESSION['e_haslo']);
		}
	
	?>

				<label>Powtórz hasło:</label> <input type="password" name="haslo2" /><br /><br />

	<?php
	
		if(isset($_SESSION['e_regulamin']))
		{
			echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
			unset($_SESSION['e_regulamin']);
		}
	
	?>

				<div class="g-recaptcha" data-sitekey="6LfDQn4UAAAAALg30Vdd15-oBwf_Ahu05mZTnPdI"></div>

	<?php
	
		if(isset($_SESSION['e_bot']))
		{
			echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
			unset($_SESSION['e_bot']);
		}
	
	?>
		<div id="registerbtn">
			<input type="submit" value="Zarejestruj się!">
		</div>
	</div>

	</form>

	</body>

	</html>