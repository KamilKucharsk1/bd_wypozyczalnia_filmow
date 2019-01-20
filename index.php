<?php
	session_start();
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Wypożyczalnia filmów wideo</title>
	<meta http-equiv="X-UA-Compatible" content ="IE=edge,chrome=1" />
	<link rel="stylesheet" href="style_index.css" type="text/css" />
</head>

<body>

	<div id="container">
		
		<div id="logo">
			<h1>Logowanie do wypożyczalni</h1>
		</div>

		<form action="zaloguj.php" method="post">

		Login: <br/> <input type="text" name="login"/><br/>
		Hasło: <br/> <input type="password" name="haslo"/><br/><br/>
		<input type="submit" value="Zaloguj się"/>

		</form>
		<?php
			if(isset($_SESSION['blad']))
				echo '<br/>'.$_SESSION['blad'].'<br/>';
		?>
		<br/>
		
		<form action="rejestracja.php">
		<input type="submit" value="Zarejestruj się!" />
		</form>

	</div>
</body>
</html>