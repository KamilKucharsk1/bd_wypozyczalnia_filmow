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
        $nowystatus = $_POST['nowystatus'];
        
                    

            $sql = "UPDATE egzemplarz SET status = ".$nowystatus." WHERE id_egzemplarz = .$numer;
            
            if($rezultat = @$polaczenie->query($sql))
            {
                header("Location: stronaglowna_pracownik.php");
            }
            else
            {
               // $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
               // header("Location: stronaglowna.php");
            }
        
        header('Location: stronaglowna_pracownik.php');
		$polaczenie->close();
	}
	
	
?>

