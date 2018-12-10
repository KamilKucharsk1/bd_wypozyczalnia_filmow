<?php
    require_once "connect.php";
		session_start();

	

	$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
	
	if($polaczenie->connect_errno!=0){
		echo "Error: ".$polaczenie->connect_errno . "Opis:".$polaczenie->connect_error;
	}
	elseif
	{

		$login = $_POST['login'];
		$haslo = $_POST['haslo'];
		//$haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);

		$sql = "SELECT * FROM klient WHERE Login='$login'";
		if($rezultat = @$polaczenie->query($sql))
		{
			$ilu_userow = $rezultat->num_rows;
			if($ilu_userow>0)
			{
				$wiersz = $rezultat->fetch_assoc();

				if(password_verify($haslo,$wiersz['haslo']))
				{

				$_SESSION['login'] = $wiersz['login'];
				$_SESSION['haslo'] = $wiersz['haslo'];
				$_SESSION['imie'] = $wiersz['imie'];
				$_SESSION['nazwisko'] = $wiersz['nazwisko'];
				$_SESSION['email'] = $wiersz['email'];
				$_SESSION['id_klienta'] = $wiersz['id_klienta'];
				
				
				unset($_SESSION['blad']);
				$rezultat->free_result();
				$_SESSION['zalogowany']=true;
				
				header('Location: stronaglowna.php');
				}
				else
				{
					$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
					header('Location: index.php');
				}
			}
			else
			{
				$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login
				lub hasło!</span>';
				header('Location: index.php');
			}
			
		}

		$polaczenie->close();
	}
	else
	{
		$login = $_POST['login'];
		$haslo = $_POST['haslo'];
		//$haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);

		$sql = "SELECT * FROM pracownik WHERE Login='$login'";
		if($rezultat = @$polaczenie->query($sql))
		{
			$ilu_userow = $rezultat->num_rows;
			if($ilu_userow>0)
			{
				$wiersz = $rezultat->fetch_assoc();

				if(password_verify($haslo,$wiersz['haslo']))
				{

				$_SESSION['login'] = $wiersz['login'];
				$_SESSION['haslo'] = $wiersz['haslo'];
				$_SESSION['imie'] = $wiersz['imie'];
				$_SESSION['nazwisko'] = $wiersz['nazwisko'];
				
				
				unset($_SESSION['blad']);
				$rezultat->free_result();
				$_SESSION['zalogowanypracownik']=true;
				
				header('Location: stronaglowna_pracownik.php');
				}
				else
				{
					$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
					header('Location: index.php');
				}
			}
			else
			{
				$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login
				lub hasło!</span>';
				header('Location: index.php');
			}
			
		}

		$polaczenie->close();
	}

?>