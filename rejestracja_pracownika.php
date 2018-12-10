<?php

    session_start();

    if(isset($_POST['nazwisko']))    //ktoras z wartosci formularza
    {
        //Udana walidacja
        $wszystko_OK = true;


        //----------------------------------------------Sprawdzenie dlugosci imienia
        $imie = $_POST['imie'];

        if((strlen($imie)<3) || (strlen($imie)>20))
        {
            $wszystko_OK = false;
            $_SESSION['e_imie']="Imię musi posiadać od 3 do 20 znaków!";
        }  

        //---------------------------------------------Sprawdzanie dlugosci nazwiska
        $nazwisko = $_POST['nazwisko'];
        
        if((strlen($nazwisko)<3) || (strlen($imie)>30))
        {
            $wszystko_OK = false;
            $_SESSION['e_nazwisko']="Nazwisko musi posiadać od 3 do 30 znaków!";
        }  

        //if(ctype_alnum($nazwisko)==false)
        //{
        //    $wszystko_OK=false;
        //    $_SESSION['e_nazwisko'] = "Nazwisko może składać się tylko z liter i cyfr (bez polskich znaków)";
        //}


        //----------------------------------------------Sprawdzenie dlugosci loginu
        $login = $_POST['login'];

        if((strlen($login)<3) || (strlen($login)>20))
        {
            $wszystko_OK = false;
            $_SESSION['e_login']="Imię musi posiadać od 3 do 20 znaków!";
        }  

        //---------------------------------------------Sprawdzanie poprawnosc hasel
        $haslo1 = $_POST['haslo1'];
        $haslo2 = $_POST['haslo2'];

        if((strlen($haslo1)<8) || (strlen($haslo2)>20))
        {
            $wszystko_OK=false;
            $_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków!";
        }

        if($haslo1!=$haslo2)
        {
            $wszystko_OK=false;
            $_SESSION['e_haslo']="Podane hasła nie są identyczne!";
        }

        $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);




        //------------------------------------------------Zapamietywanie wprowadzonych danych
        $_SESSION['fr_imie'] =$imie;
        $_SESSION['nazwisko'] =$nazwisko;
        $_SESSION['fr_login'] =$login;
        $_SESSION['fr_haslo1'] =$haslo1;
        $_SESSION['fr_haslo2'] =$haslo2;


        //----------------------------------------------Sprawdzanie czy uzytkownik juz istnieje

        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);    // raportowanie exceptions zamiast warningow

        try{
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
            if($polaczenie->connect_errno!=0)
            {
                throw new Exception(mysqli_connect_errno());
            }
            else
            {
                
                //czy login jest juz zarezerwowany
                $rezultat =$polaczenie->query("SELECT id_pracownik FROM pracownik WHERE login='$login'");

                if(!$rezultat) throw new Exception($polaczenie->error);

                $ile_takich_loginow = $rezultat->num_rows;
                if($ile_takich_loginow>0)
                {
                    $wszystko_OK=false;
                    $_SESSION[e_login]="Istnieje już pracownik o takim loginie!";
                }



                        if($wszystko_OK == true)
                            {
                              if($polaczenie->query("INSERT INTO `pracownik` (`id_pracownik`, `imie`, `nazwisko`, `login`, `haslo`) VALUES (NULL, '$imie', '$nazwisko', '$login', '$haslo_hash')"))
                              {
                                $_SESSION['udanarejestracja']=true;
                                echo "Nowy pracownik został dodany!";          
                              }
                             
                            }


                $polaczenie->close();
            }
        }
        catch(Exception $e){
            echo '<span style="color:red;">Bład serwera!</span>';
            echo '<br/>Info dev: '.$e;
        }








    }

?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rejestracja</title>
    <!--<link rel="stylesheet" href="style1.css" />-->
    <link href="https://fonts.googleapis.com/css?family=Merienda:400,700&amp;subset=latin-ext" rel="stylesheet">
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <style>
        .error{
            color:red;
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>

</head>

<body>

	<h1>Rejestracja nowego pracownika</h1>

<form method="post">

    Imię: <input type="text" value="<?php
    if(isset($_SESSION['fr_imie']))
        echo $_SESSION['fr_imie'];
        unset($_SESSION['fr_imie']);
    ?>" name="imie"/><br/>
    <?php
        if(isset($_SESSION['e_imie']))
        {
            echo '<div class="error">'.$_SESSION['e_imie'].'</div>';
            unset($_SESSION['e_imie']);
        }
    ?>
    Nazwisko: <input type="text" value="<?php
    if(isset($_SESSION['fr_nazwisko']))
        echo $_SESSION['fr_nazwisko'];
        unset($_SESSION['fr_nazwisko']);
    ?>" name="nazwisko"/><br/>
    <?php
        if(isset($_SESSION['e_nazwisko']))
        {
            echo '<div class="error">'.$_SESSION['e_nazwisko'].'</div>';
            unset($_SESSION['e_nazwisko']);
        }
    ?>
    
    Login: <input type="text" value="<?php
    if(isset($_SESSION['fr_login']))
        echo $_SESSION['fr_login'];
        unset($_SESSION['fr_login']);
    ?>" name="login"/><br/>
    <?php
        if(isset($_SESSION['e_login']))
        {
            echo '<div class="error">'.$_SESSION['e_login'].'</div>';
            unset($_SESSION['e_login']);
        }
    ?>
    Hasło: <input type="password" value="<?php
    if(isset($_SESSION['fr_haslo1']))
        echo $_SESSION['fr_haslo1'];
        unset($_SESSION['fr_haslo1']);
    ?>" name="haslo1"/><br/>
    <?php
        if(isset($_SESSION['e_haslo']))
        {
            echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
            unset($_SESSION['e_haslo']);
        }
    ?>
    Powtórz hasło: <input type="password" value="<?php
    if(isset($_SESSION['fr_haslo2']))
        echo $_SESSION['fr_haslo2'];
        unset($_SESSION['fr_haslo2']);
    ?>" name="haslo2"/><br/>


    <br/>
    <input type="submit" value="Zarejestruj"/>



</form>



</body>
</html>