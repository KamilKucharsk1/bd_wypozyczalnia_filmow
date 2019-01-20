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
	<link rel="stylesheet" href="style_stronaglowna.css" type="text/css" />
</head>

<body>
	<div id="container">
		<?php
			echo "Witaj ".$_SESSION['imie']." ".$_SESSION['nazwisko'].'!  <form action="logout.php"><input type="submit" value="Wyloguj się!" />
		</form><br/><br/>';
			
			echo "<b>Dodaj recenzję filmu:</b><br/><br/>";
		?>


		<form action="dodajrecenzje.php" method="post">

		Nr filmu: <br/> <input type="text" name="numer"/><br/>
		Ocena: <br/> <input type="text" name="ocena"/><br/>
		Opis: <br/> <input type="text" name="opis"/><br/><br/>
		<input type="submit" value="Dodaj recenzję"/><br/><br/>

		</form>

		<?php
			echo "<b>Wypożycz swój ulubiony film:</b><br/><br/>";
		?>

		<form action="dodajwypozyczenie.php" method="post">

		Numer egzemplarza: <br/> <input type="text" name="numer"/><br/>
		Data rezerwacji (Format: YYYY-MM-DD): <br/> <input type="text" name="data"/><br/><br/>
		<input type="submit" value="Zarezerwuj pozycję"/><br/><br/>

		</form>


		<?php
			if(isset($_SESSION['blad']))	echo $_SESSION['blad'];
			
			$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
			
			if($polaczenie->connect_errno!=0){
				echo "Error: ".$polaczenie->connect_errno . "Opis:".$polaczenie->connect_error;
			}
			else
			{
				
				
				echo "<h2>Dostępne filmy: </h2>";
				
				
				
				$sql = "SELECT id_film, tytul, rezyser, rok_produkcji, gatunek FROM `film`";

				$rezultat = @$polaczenie->query($sql);
				
				if($rezultat->num_rows > 0)
				{
					echo '<table style="width:100%">';
					
					echo '<tr><th>L.p.</th><th>Tytuł</th> <th>Reżyser</th><th>Gatunek</th><th>Średnia ocena</th><th>Dostępne egzemlarze</th></tr>';
					
					while($row = $rezultat->fetch_assoc()) 
					{
						$idFilm = $row["id_film"];
						$sqlSrednia = "SELECT AVG(ocena) average FROM recenzja WHERE id_film = '$idFilm'";
						$srednia = @$polaczenie->query($sqlSrednia);
						
						$sqlEgzemplarze = "SELECT * FROM egzemplarz WHERE status = 'w' AND id_film = '$idFilm'";
						$egzemplarze = @$polaczenie->query($sqlEgzemplarze);
						
						echo "<tr><th>".$row["id_film"]."</th><th>" . $row["tytul"]. " </th><th>" . $row["rezyser"]. " </th><th>" . $row["gatunek"]."</th>";
						
						if($row2 = $srednia->fetch_assoc())
						{
							echo "<th>".$row2['average']."</th>";
						}
						
						echo "<th>";
						
						foreach($egzemplarze as $row3) {
							echo $row3['id_egzemplarz'].",";
						}
						
						echo "</th></tr>";
					}
					
					echo "</table><br/>";
					
				}
				else 
				{
					echo '<br/><span style="color:red">Nie ma żadnych dostępnych filmów!</span><br/>';
				}
				
				echo "<h2>Twoje wypożyczenia:</h2>";
				
				$id = $_SESSION['id_klienta'];
				$sql = "SELECT id_egzemplarz, data_oddania, data_wypozyczenia FROM wypozyczenie WHERE id_klienta = $id'";	
				
				error_reporting(E_ALL ^ E_NOTICE); 
				$rezultat = @$polaczenie->query($sql);
				
				if($rezultat->num_rows > 0)
				{
					echo '<table style="width:60%">';
					echo "<tr><th>Nr egzemplarza</th><th>Data oddania</th><th>Data wypożyczenia</th></tr>";
					while($row = $rezultat->fetch_assoc()) 
					{
					echo "<tr><th> " . $row["id_egzemplarz"]. " </th><th>" . $row["data_oddania"]. " </th><th>" . $row["data_wypozyczenia"]. "</th></tr>";
					}
					echo '</table>';
				}
				else  
				{
					echo '<br/><span style="color:red">Nie ma w historii żadnych wypożyczeń!</span><br/>';
				}
				
				echo "<h2>Twoje recenzje: </h2>";
				$id = $_SESSION['id_klienta'];
				$sql = "SELECT opis, ocena, id_film FROM recenzja WHERE id_klient = '$id'";	
				
				error_reporting(E_ALL ^ E_NOTICE); 
				$rezultat = @$polaczenie->query($sql);
				
				if($rezultat->num_rows > 0)
				{
					echo '<table style="width:60%">';
					echo "<tr><th>Film</th><th>Ocena</th><th>Opis</th></tr>";
					while($row = $rezultat->fetch_assoc()) 
					{
					echo "<tr><th> " . $row["id_film"]. " </th><th>" . $row["ocena"]. " </th><th> " . $row["opis"]. "</th></tr>";
					}
					echo '</table>';
				}
				else 
				{
					echo '<br/><span style="color:red">Nie ma w historii żadnych recenzji!</span><br/>';
				}
				

				$polaczenie->close();
			}
			
			
		?>
	</div>
</body>
</html>