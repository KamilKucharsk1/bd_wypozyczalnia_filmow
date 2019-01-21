<?php

	require_once "connect.php";
	
	session_start();
	
	$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
	
	if($polaczenie->connect_errno!=0){
		echo "Error: ".$polaczenie->connect_errno . "Opis:".$polaczenie->connect_error;
	}
	else
	{

		$tytul = $_POST['tytul'];
		$rezyser = $_POST['rezyser'];
		$rok_produkcji = $_POST['rok_produkcji'];
		$gatunek = $_POST['gatunek'];
		
		

		$sql = "INSERT INTO film (`id_film`, `tytul`, `rezyser`, `rok_produkcji`, `gatunek`) VALUES (NULL, '$tytul', '$rezyser', '$rok_produkcji', '$gatunek')";
		
		
		if($rezultat = @$polaczenie->query($sql))
		{
			header('Location: stronaglowna_pracownik.php');
		}
		else
		{
			$_SESSION['blad'] = '<span style="color:red">Nieprawidłowo wypełniony formularz dodawania!</span>';
			header('Location: stronaglowna_pracownik.php');
		}
		$polaczenie->close();
	}
	
	
?>

