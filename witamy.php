<?php
	session_start();
	
	if(!isset($_SESSION['udanarejestracja']))
	{
		header('Location: index.php');
		exit();
	}
	else
	{
		unset($_SESSION['udanarejestracja']);
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
		<h3>Dziękuję za rejestrację w serwisie!</br>
			Możesz już zalogować się na swoje konto!</h3>
			</br></br>
		<a href="index.php">Zaloguj się!</a>
	</div>

</body>

</html>