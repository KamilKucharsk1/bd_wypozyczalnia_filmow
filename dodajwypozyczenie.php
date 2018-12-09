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
		$data = $_POST['data'];
		$id = $_SESSION['id_klienta'];
		
		$date = date("Y-m-d", strtotime(str_replace('-', '/', $data)));
		
		$sql = "INSERT INTO `wypozyczenie` (`id_wypozyczenie`, `id_egzemplarz`, `data_wypozyczenia`, `data_oddania`, `id_klienta`) VALUES (NULL, '$numer', '$date', NULL, '$id')";
		$sqlUpdate = "UPDATE egzemplarz SET status = 'z' WHERE egzemplarz.id_egzemplarz = '$numer'";
		
		if($rezultat = @$polaczenie->query($sql))
		{
			if($rezultat2 = @$polaczenie->query($sqlUpdate))
			{
				unset($_SESSION['blad']);
				header('Location: stronaglowna.php');
			}
			else
			{
				$_SESSION['blad'] = '<span style="color:red">Nieprawidłowe dane w zapytaniu UPDATE!</span>';
				header('Location: stronaglowna.php');
			}
		}
		else
		{
			$_SESSION['blad'] = '<span style="color:red">Nieprawidłowe dane wejściowe!</span><br/>';
			header('Location: stronaglowna.php');
		}
		$polaczenie->close();
	}
	
	
?>

