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

	<script data-ad-client="ca-pub-9022779141538686" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
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
					<li><a href="https://docs.google.com/forms/d/e/1FAIpQLSetnCIa57fRRX5mx1u4klAUDUAJMxSrbM7QHHjB5MmzSVVs8g/viewform?usp=sf_link">Zgłoś bug</a></li>
					<li><a href="https://docs.google.com/forms/d/e/1FAIpQLSfaxOd7QKIyFk0kvbCbOkR64dpye-hAfWYTcoS3plrV_7tGrw/viewform?usp=sf_link">Zgłoś złą odpowiedź</a></li>
				</ul>
			</nav>
		</div>
<!--
		<div class="container" id="register">
			<a href ="rejestracja.php">Rejestracja - załóż konto!</a>
		</div>

		<div class="container">
			<form action ="zaloguj.php" method="post">
	
			<label>Login:</label> <input type="text" name="login"/> <br />
			<label>Hasło:<label> <input type="password" name="haslo" /> <br /><br />
				<input type="submit" value="Zaloguj się" />
		</div>
			</form> -->
			<div class="container">
			</br>
			1. Hasła są szyfrowane, ale strona jest amatorska, więc użyj innego niż do banku.</br></br>
			2. Jeśli uznacie, że jakaś odpowiedź jest zła prześlicie to formularzem - zmienię według waszego uznania, ale nie będę tego sprawdzał.</br></br>
			3. Jeśli znajdziesz bug na stronie, który przeszkadza w rozgrywce prześlij formularzem. </br></br>
			4. Proszę o nie spamowanie na priv - od tego są formularze.</br></br>
			5. Bawcie się dobrze :D

			</div>
	
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