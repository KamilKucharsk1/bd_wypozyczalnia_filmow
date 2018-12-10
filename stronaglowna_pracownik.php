<?php

	require_once "connect.php";
	
	session_start();
	
	if(!isset($_SESSION['zalogowanypracownik']))
	{
		header('Location: index.php');
		exit();
	}
	
?>

<!DOCTYPE HTML>
<html lang ="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1"/>
	<title>Wypożyczalnia kaset wideo</title>
</head>

<body>
<?php
    echo "Witaj ".$_SESSION['imie']." ".$_SESSION['nazwisko'].'! [ <a href="logout.php">Wyloguj się!</a> ]</p><br/><br/>';
    

    //dodaj pracownika usun pracownika
    //usun klienta
    //dodaj usun egzemplarz
    //dodaj usun tytul
?>




<h2>Pracownicy</h2><br/><br/>
<a href="rejestracja_pracownika.php">Dodaj nowego pracownika</a>
<?php
	if(isset($_SESSION['blad']))	echo $_SESSION['blad'];
	
	$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
	
	if($polaczenie->connect_errno!=0){
		echo "Error: ".$polaczenie->connect_errno . "Opis:".$polaczenie->connect_error;
	}
	else
	{
	/*	
		
		echo "Pracownicy: <br/>";
		
		
		$sql = "SELECT id_pracownik, imie, nazwisko, login FROM `pracownik`";

		$rezultat = @$polaczenie->query($sql);
		
		if($rezultat->num_rows > 0)
		{
			while($row = $rezultat->fetch_assoc()) 
			{
				$idPracownik = $row["id_pracownik"];
				
				$sqlPracownik = "SELECT * FROM pracownik";
				$pracownicy = @$polaczenie->query($sqlPracownik);
				
				echo "<b>".$row["id_pracownik"]."</b> "."<b>Imię: </b> " . $row["imie"]. " <b>Nazwisko: </b>" . $row["nazwisko"]."<b>Login: </b> ".$row["login"];
			
			}
			
		}*/
    }
?>

<h2>Klienci</h2><br/><br/>
<?php
	if(isset($_SESSION['blad']))	echo $_SESSION['blad'];
	
	$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
	
	if($polaczenie->connect_errno!=0){
		echo "Error: ".$polaczenie->connect_errno . "Opis:".$polaczenie->connect_error;
	}
	else
	{		
		echo "Lista klientów: <br/>";
				
		$sql = "SELECT id_klient, imie, nazwisko, email, login, haslo FROM `klient`";

		$rezultat = @$polaczenie->query($sql);
		
		if($rezultat->num_rows > 0)
		{
			while($row = $rezultat->fetch_assoc()) 
			{
				$idKlient = $row["id_klient"];
				
				$sqlKlient = "SELECT * FROM klient";
				$klienci = @$polaczenie->query($sqlKlient);
				
				echo "<b>".$row["id_klient"]."</b> "."<b>Imię: </b> " . $row["imie"]. " <b>Nazwisko: </b>" . $row["nazwisko"]."<b>Email: </b> " . $row["email"]."<b>Login: </b> ".$row["login"];
                echo "<br/><br/>";
            }
			
		}
    }
?>



<h2>Filmy</h2><br/><br/>
<?php
	$sql = "SELECT id_film, tytul, rezyser, rok_produkcji, gatunek FROM `film`";

		$rezultat = @$polaczenie->query($sql);
		
		if($rezultat->num_rows > 0)
		{
			while($row = $rezultat->fetch_assoc()) 
			{
				$idFilm = $row["id_film"];
				$sqlSrednia = "SELECT AVG(ocena) average FROM recenzja WHERE id_film = '$idFilm'";
				$srednia = @$polaczenie->query($sqlSrednia);
				
				$sqlEgzemplarze = "SELECT * FROM egzemplarz WHERE id_film = '$idFilm'";
				$egzemplarze = @$polaczenie->query($sqlEgzemplarze);
				
				echo "<b>".$row["id_film"]."</b> "."<b>Tytul:</b> " . $row["tytul"]. " <b>Reżyser: </b>" . $row["rezyser"]. " <b>Gatunek:</b> " . $row["gatunek"];
				
				if($row2 = $srednia->fetch_assoc())
				{
					echo "<b> Średnia ocena: </b>".$row2['average'];
				}
				
				echo "<b> Dostępne egzemplarze: </b>";
				
				foreach($egzemplarze as $row3) {
					echo $row3['id_egzemplarz'].$row3['status'].", ";
				}
				
				echo "<br/><br/>";
            
            }
        }
        ?>

        <h3>Dodaj egzemplarz</h3>
        
    <form action="dodajegzemplarz.php" method="post">
    Numer tytulu: <input type="text" name="numer"/><br/>
    Ilość: <input type="text" name="ilosc_egzemplarzy"><br/>
   <input type="submit" value="Dodaj"/><br/><br/>
    </form>
    

    <h2>Usun egzemplarz:</h2>
    <form action="usunegzemplarz.php" method="post">
    Numer egzemplarza: <input type="text" name="numer"/><br/>
   <input type="submit" value="Usuń"/><br/><br/>
    </form>
<!--
     <h2>Zmien status filmu:</h2>
    <form action="edytujegzemplarz.php" method="post">
    Numer egzemplarza: <input type="text" name="numer"/><br/>
    Nowy status: <input type="text" name="nowystatus"/><br/>
   <input type="submit" value="Zmień"/><br/><br/>
    </form>
    -->
<!--
    <h2>Usun klienta:</h2>
    <form action="usunklienta.php" method="post">
    Numer egzemplarza: <input type="text" name="numer"/><br/>
   <input type="submit" value="Usuń"/><br/><br/>
    </form>
    -->  



</body>
</html>