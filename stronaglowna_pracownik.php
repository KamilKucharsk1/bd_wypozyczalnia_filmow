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
	<link rel="stylesheet" href="style_stronaglowna_pracownik.css" />

	<title>Wypożyczalnia kaset wideo</title>
</head>

<body>
	<div id="container">
<?php
    echo "Witaj ".$_SESSION['imie']." ".$_SESSION['nazwisko'].'! <form action="logout.php"><input type="submit" value="Wyloguj się!" />
		</form><br/><br/>';
    

    //dodaj pracownika usun pracownika
    //usun klienta
    //dodaj usun egzemplarz
    //dodaj usun tytul
?>




<h2>Pracownicy</h2><br/><br/>
<form action="rejestracja_pracownika.php">
		<input type="submit" value="Zarejestruj pracownika!" />
		</form>
<?php
	if(isset($_SESSION['blad']))	echo $_SESSION['blad'];
	
	$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);

	
	if($polaczenie->connect_errno!=0){
		echo "Error: ".$polaczenie->connect_errno . "Opis:".$polaczenie->connect_error;
	}
	else
	{
		
		
		echo "Lista pracowników: <br/>";
		echo '<table style="width:100%">';
					
		echo '<tr><th>L.p.</th><th>Imie</th> <th>Nazwisko</th><th> Login</th><th>Hasło</th></tr>';
		
		$sql = "SELECT * FROM `pracownik`";

		$rezultat = @$polaczenie->query($sql);
		
		if($rezultat->num_rows > 0)
		{
			while($row = $rezultat->fetch_assoc()) 
			{
				$idPracownik = $row["id_pracownik"];
				
				$sqlPracownik = "SELECT * FROM pracownik";
				$pracownicy = @$polaczenie->query($sqlPracownik);
				echo "<tr><th> " . $row["id_pracownik"]. " </th><th>" . $row["imie"]. " </th><th>" . $row["nazwisko"]. " </th><th>" . $row["login"]. " </th><th>" . $row["haslo"].  "</th></tr>";
				//echo "<b>".$row["id_pracownik"]."</b> "."<b>Imię: </b> " . $row["imie"]. " <b>Nazwisko: </b>" . $row["nazwisko"]."<b>Login: </b> ".$row["login"];
			
			}
			echo '</table>';

		}
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
				
		echo '<table style="width:100%">';
					
		echo '<tr><th>L.p.</th><th>Imie</th> <th>Nazwisko</th><th>Email</th><th> Login</th><th>Hasło</th></tr>';
		$sql = "SELECT id_klient, imie, nazwisko, email, login, haslo FROM `klient`";

		$rezultat = @$polaczenie->query($sql);
		
		if($rezultat->num_rows > 0)
		{
			while($row = $rezultat->fetch_assoc()) 
			{
				$idKlient = $row["id_klient"];
				
				$sqlKlient = "SELECT * FROM klient";
				$klienci = @$polaczenie->query($sqlKlient);
				echo "<tr><th> " . $row["id_klient"]. " </th><th>" . $row["imie"]. " </th><th>" . $row["nazwisko"]. " </th><th>" . $row["email"]. " </th><th>" . $row["login"]. " </th><th>" . $row["haslo"].  "</th></tr>";
				//echo "<b>".$row["id_klient"]."</b> "."<b>Imię: </b> " . $row["imie"]. " <b>Nazwisko: </b>" . $row["nazwisko"]."<b>Email: </b> " . $row["email"]."<b>Login: </b> ".$row["login"];
                //echo "<br/><br/>";
			}
			echo '</table>';
			
		}
    }
?>

<h2>Wypożyczenia:</h2><br/><br/>
<?php
echo "Lista wypożyczeń: <br/>";
	$sql = "SELECT id_wypozyczenie, id_egzemplarz, data_wypozyczenia, data_oddania, id_klient FROM `wypozyczenie`";

		$rezultat = @$polaczenie->query($sql);
		echo '<table style="width:100%">';
					
				echo '<tr><th>id wypozyczenia</th><th>id egzemplarz</th> <th>Data wypożyczenia</th><th>Data oddania</th><th>id klienta</th></tr>';
		if($rezultat->num_rows > 0)
		{
			while($row = $rezultat->fetch_assoc()) 
			{
				$idWypozyczenie = $row["id_wypozyczenie"];
				
				$sqlEgzemplarze = "SELECT * FROM wypozyczenie WHERE id_wypozyczenie = '$idWypozyczenie'";
				$egzemplarze = @$polaczenie->query($sqlEgzemplarze);
				
				//echo "<b>".$row["id_film"]."</b> "."<b>Tytul:</b> " . $row["tytul"]. " <b>Reżyser: </b>" . $row["rezyser"]. " <b>Gatunek:</b> " . $row["gatunek"];
				echo "<tr><th> " . $row["id_wypozyczenie"]. " </th><th>" . $row["id_egzemplarz"]. " </th><th>" . $row["data_wypozyczenia"]. " </th><th>" . $row["data_oddania"]. " </th><th>" . $row["id_klient"]."</th>";


				
				echo "</th></tr>";
				
			}
			echo "</table><br/>";
        }
        ?>







<h2>Filmy</h2><br/><br/>
<?php
echo "Lista filmów: <br/>";
	$sql = "SELECT id_film, tytul, rezyser, rok_produkcji, gatunek FROM `film`";

		$rezultat = @$polaczenie->query($sql);
		echo '<table style="width:100%">';
					
				echo '<tr><th>id filmu</th><th>Tytuł</th> <th>Reżyser</th><th>Gatunek</th><th>Średnia</th><th>Dostępne egzemplarze</th></tr>';
		if($rezultat->num_rows > 0)
		{
			while($row = $rezultat->fetch_assoc()) 
			{
				$idFilm = $row["id_film"];
				$sqlSrednia = "SELECT AVG(ocena) average FROM recenzja WHERE id_film = '$idFilm'";
				$srednia = @$polaczenie->query($sqlSrednia);
				
				$sqlEgzemplarze = "SELECT * FROM egzemplarz WHERE id_film = '$idFilm'";
				$egzemplarze = @$polaczenie->query($sqlEgzemplarze);
				
				//echo "<b>".$row["id_film"]."</b> "."<b>Tytul:</b> " . $row["tytul"]. " <b>Reżyser: </b>" . $row["rezyser"]. " <b>Gatunek:</b> " . $row["gatunek"];
				echo "<tr><th> " . $row["id_film"]. " </th><th>" . $row["tytul"]. " </th><th>" . $row["rezyser"]. " </th><th>" . $row["gatunek"]."</th>";


				if($row2 = $srednia->fetch_assoc())
				{
					//echo "<b> Średnia ocena: </b>".$row2['average'];
					echo "<th>".$row2['average']."</th>";
				}
				echo "<th>";

				
				

				foreach($egzemplarze as $row3) {
					echo $row3['id_egzemplarz'].$row3['status'].", ";
				}
				
				//echo "<br/><br/>";
				echo "</th></tr>";
				
			}
			echo "</table><br/>";
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
	

	<h2>Dodaj tytuł:</h2>
	<form action="dodajtytul.php" method="post">
	Nowy tytuł: <input type="text" name="tytul"/><br/>
	Reżyser: <input type='text' name="rezyser"/><br/>
	Rok produkcji: <input type='text' name="rok_produkcji"/><br/>
	Gatunek: <input type='text' name="gatunek"/><br/>
	<input type="submit" value="Dodaj do kolekcji"/><br/><br/>

<!--
     <h2>Zmien status filmu:</h2>
    <form action="edytujpozycje.php" method="post">
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


</div>
</body>
</html>