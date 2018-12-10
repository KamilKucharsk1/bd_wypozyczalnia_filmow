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
        $ilosc = $_POST['ilosc_egzemplarzy'];
        
        for ($x = 0; $x < $ilosc; $x++) 
        {
            $sql = "INSERT INTO egzemplarz (`id_egzemplarz`, `id_film`, `status`) VALUES (NULL, '$numer', 'w')";
            
            if($rezultat = @$polaczenie->query($sql))
            {
                
            }
            else
            {
                //$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login
                //lub hasło!</span>';
                //header('Location: stronaglowna.php');
            }
        }
        header('Location: stronaglowna_pracownik.php');
		$polaczenie->close();
	}
	
	
?>

