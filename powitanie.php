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


//Usuwanie zmiennyych pamiętanych w formularzu rejestracja zmienne wpisywane do formularza
if(isset($_SESSION['fr_imie'])) unset($_SESSION['fr_imie']);
if(isset($_SESSION['fr_nazwisko'])) unset($_SESSION['fr_nazwisko']);
if(isset($_SESSION['fr_login'])) unset($_SESSION['fr_login']);
if(isset($_SESSION['fr_haslo1'])) unset($_SESSION['fr_haslo1']);
if(isset($_SESSION['fr_haslo2'])) unset($_SESSION['fr_haslo2']);
if(isset($_SESSION['fr_wiek'])) unset($_SESSION['fr_wiek']);
if(isset($_SESSION['fr_regulamin'])) unset($_SESSION['fr_regulamin']);


//Usuwanie błędów rejestracji
if(isset($_SESSION['e_imie'])) unset($_SESSION['e_login']);
if(isset($_SESSION['e_nazwisko'])) unset($_SESSION['e_nazwisko']);
if(isset($_SESSION['e_login'])) unset($_SESSION['e_login']);
if(isset($_SESSION['e_haslo1'])) unset($_SESSION['e_haslo1']);
if(isset($_SESSION['e_haslo2'])) unset($_SESSION['e_haslo2']);
if(isset($_SESSION['e_wiek'])) unset($_SESSION['e_wiek']);
if(isset($_SESSION['e_regulamin'])) unset($_SESSION['e_regulamin']);
if(isset($_SESSION['e_bot'])) unset($_SESSION['e_bot']);


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