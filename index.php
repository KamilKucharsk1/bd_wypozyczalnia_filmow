<?php
	session_start();
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content ="IE=edge,chrome=1" />
</head>

<body>

	<h1>Logowanie do wypozyczalni</h1>

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
<a href="rejestracja.php">Zarejestruj się w systemie!</a>

</body>
</html>