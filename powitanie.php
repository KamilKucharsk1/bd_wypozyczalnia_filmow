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
	<meta http-equiv="X-UA-Compatible" content ="IE=edge,chrome=1" />
</head>

<body>

	<h1>Witamy w wypożyczalni, możesz się już zalogować</h1>

    <a href="index.php">Rejestracja przebiegła pomyślnie, zaloguj się na swoje konto!</a>
    <br/>
    <br/>
</body>
</html>