<?php

	require_once "connect.php";
	
    
    
    $polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);


    if($polaczenie->connect_errno!){
		echo "Error: ".$polaczenie->connect_errno . "Opis:".$polaczenie->connect_error;
    }else
    {

        $numer = $_POST['numer'];
        $nowystatus = $_POST['nowystatus'];

        $sql = "UPDATE `egzemplarz` SET `status` = '$nowystatus' WHERE `egzemplarz`.`id_egzemplarz` = '$numer'";

        
        if($rezultat = @$polaczenie->query($sql) === true)
        {
            header('Location: stronaglowna_pracownik.php');
        }
        else
        {
            $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login
            lub hasło!</span>';
            header('Location: stronaglowna_pracownik.php');
        }
        $polaczenie->close();
    }


?>