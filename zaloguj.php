<?php

    require_once "connect.php";

	$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
	
	if($polaczenie->connect_errno!=0){
		echo "Error: ".$polaczenie->connect_errno . "Opis:".$polaczenie->connect_error;
	}
	else
	{

		$login = $_POST['login'];
		$haslo = $_POST['haslo'];

		echo "oke";
		$sql = "SELECT * FROM klient WHERE Login='$login' AND Haslo='$haslo'";
		echo $login;
		if($rezultat = @$polaczenie->query($sql))
		{
				$ilu_userow = $rezultat->num_rows;
				if($ilu_userow>0)
				{
					$wiersz = $rezultat->fetch_assoc();
					$user = $wiersz['Login'];

					$rezultat->free_result();

					echo $user;
				}
		}

		$polaczenie->close();
	}

	



?>