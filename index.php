<?php
	session_start();
	
	if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: gra.php');
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

	<main>

		<div class="container" id="showcase">
			<h1>Zostań inżynierem</h1>
			<h2>Quiz z pytaniami egzaminacyjnymi</h2>
		</div>	
		<div class="container" id="nav">
			<nav class="navi">
				<ul class="navi">
					<li><a href="index.php">Home</a></li>
					<li><a href="regulamin.php">Regulamin</a></li>
					<li><a href="about.php">O autorze</a></li>
					<li><a href="contact.php">Kontakt</a></li>
				</ul>
			</nav>
		</div>

		<div class="container" id="register">
			<a href ="rejestracja.php">Rejestracja - załóż konto!</a>
		</div>

		<div class="container">
			<form action ="zaloguj.php" method="post">
	
			<label>Login:</label> <input type="text" name="login"/> <br />
			<label>Hasło:<label> <input type="password" name="haslo" /> <br /><br />
				<input type="submit" value="Zaloguj się" />
		</div>
			</form>
	</main>

	<?php
	if(isset($_SESSION['blad'])) echo $_SESSION['blad'];
	?>
	
	<footer>
		<div class="container">
			<p>Copyright &copy; 2019</p>
		</div>
	</footer>

</body>
</html>