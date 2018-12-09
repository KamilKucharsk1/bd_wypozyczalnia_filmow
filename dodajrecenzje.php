<?php

	require_once "connect.php";
	
	session_start();
	
	$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
	
	if($polaczenie->connect_errno!=0){
		echo "Error: ".$polaczenie->connect_errno . "Opis:".$polaczenie->connect_error;
	}
	else
	{

		$numer = $_POST['numer'];
		$ocena = $_POST['ocena'];
		$opis = $_POST['opis'];
		$id = $_SESSION['id_klienta'];
		
		

		$sql = "INSERT INTO recenzja (`id_recenzja`, `ocena`, `opis`, `id_klient`, `id_film`) VALUES (NULL, '$ocena', '$opis', '$id', '$numer')";
		
		
		if($rezultat = @$polaczenie->query($sql))
		{
			header('Location: stronaglowna.php');
		}
		else
		{
			$_SESSION['blad'] = '<span style="color:red">Nieprawidłowe dane wejściowe!</span>';
			header('Location: stronaglowna.php');
		}
		$polaczenie->close();
	}
	
	
?>

