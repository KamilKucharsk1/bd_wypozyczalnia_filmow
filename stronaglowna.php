<?php

	require_once "connect.php";
	
	session_start();
	
	if(!isset($_SESSION['zalogowany']))
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
	echo "Witaj ".$_SESSION['imie']." ".$_SESSION['nazwisko']."!<br/><br/>";
	
	echo "Dodaj recenzję filmu:<br/>";
?>


<form action="dodajrecenzje.php" method="post">

Nr filmu: <br/> <input type="text" name="numer"/><br/>
Ocena: <br/> <input type="text" name="ocena"/><br/>
Opis: <br/> <input type="text" name="opis"/><br/><br/>
<input type="submit" value="Dodaj recenzję"/><br/><br/>

</form>

<?php
	
	$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
	
	if($polaczenie->connect_errno!=0){
		echo "Error: ".$polaczenie->connect_errno . "Opis:".$polaczenie->connect_error;
	}
	else
	{
		
		
		echo "Dostępne filmy: <br/>";
		
		
		$sql = "SELECT id_film, tytul, rezyser, rok_produkcji, gatunek FROM `film`";	
		
		$rezultat = @$polaczenie->query($sql);
		
		if($rezultat->num_rows > 0)
		{
			while($row = $rezultat->fetch_assoc()) 
			{
			echo "<b>".$row["id_film"]."</b> "."<b>Tytul:</b> " . $row["tytul"]. " <b>Reżyser: </b>" . $row["rezyser"]. " <b>Gatunek:</b> " . $row["gatunek"]. "<br><br/>";
			}
			
		}
		else 
		{
			echo '<br/><span style="color:red">Nie ma żadnych dostępnych filmów!</span><br/>';
		}
		
		echo "Twoje wypożyczenia: <br/>";
		
		$id = $_SESSION['id_klienta'];
		$sql = "SELECT id_egzemplarz, data_oddania, data_wypozyczenia FROM wypozyczenie WHERE id_klienta = '$id'";	
		
		$rezultat = @$polaczenie->query($sql);
		
		if($rezultat->num_rows > 0)
		{
			while($row = $rezultat->fetch_assoc()) 
			{
			echo "<b>Nr egzemplarza:</b> " . $row["id_egzemplarz"]. " <b>Data oddania: </b>" . $row["data_oddania"]. " <b>Data wypożyczenia:</b> " . $row["data_wypozyczenia"]. "<br><br/>";
			}
			
		}
		else 
		{
			echo '<br/><span style="color:red">Nie ma w historii żadnych wypożyczeń!</span><br/>';
		}
		
		echo "Twoje recenzje: <br/>";
		$id = $_SESSION['id_klienta'];
		$sql = "SELECT opis, ocena, id_film FROM recenzja WHERE id_klient = '$id'";	
		
		$rezultat = @$polaczenie->query($sql);
		
		if($rezultat->num_rows > 0)
		{
			while($row = $rezultat->fetch_assoc()) 
			{
			echo "<b>Film:</b> " . $row["id_film"]. " <b>Ocena: </b>" . $row["ocena"]. " <b>Opis:</b> " . $row["opis"]. "<br><br/>";
			}
			
		}
		else 
		{
			echo '<br/><span style="color:red">Nie ma w historii żadnych recenzji!</span><br/>';
		}
		

		$polaczenie->close();
	}
	
	
?>

</body>
</html>