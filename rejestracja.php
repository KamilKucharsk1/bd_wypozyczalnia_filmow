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

        //if(ctype_alnum($imie)==false)
        //{
        //    $wszystko_OK=false;
        //    $_SESSION['e_imie'] = "Imie może składać się tylko z liter i cyfr (bez polskich znaków)";
        //}

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


        //---------------------------------------------Sprawdzanie poprawnosci email
        $email = $_POST['email'];
        $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);    //email Bezpieczny

        if((filter_var($emailB, FILTER_SANITIZE_EMAIL)==false) || ($emailB!=$email))  // sanityzacja emaila
        {
            $wszystko_OK=false;
            $_SESSION['e_email']="Podja poprawny adres email!";
        }




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



        //----------------------------------------------Sprawdzenie wieku
        $wiek = $_POST['wiek'];

        if(($wiek<13) || ($wiek>120))
        {
            $wszystko_OK = false;
            $_SESSION['e_wiek']="Podaj swój wiek w latach!";
        }  


        //---------------------------------------------Sprawdzanie akceptacji regulaminu

        if(!isset($_POST['regulamin']))
        {
            $wszystko_OK=false;
            $_SESSION['e_regulamin']="Potwierdz akceptacje regulaminu!";
        }



        //---------------------------------------------Sprawdzanie reCAPTCHA

        $sekret = "6LcWgH8UAAAAAMZi7kRkzl97bmZ4JMtk1FIP9630";

        $sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);

        $odpowiedz = json_decode($sprawdz);

        if($odpowiedz->success == false)
        {
            $wszystko_OK=false;
            $_SESSION['e_bot']="Potwierdz, że nie jesteś botem!";
        }


        //------------------------------------------------Zapamietywanie wprowadzonych danych
        $_SESSION['fr_imie'] =$imie;
        $_SESSION['nazwisko'] =$nazwisko;
        $_SESSION['fr_login'] =$login;
        $_SESSION['fr_haslo1'] =$haslo1;
        $_SESSION['fr_haslo2'] =$haslo2;
        $_SESSION['fr_wiek'] =$wiek;
        $_SESSION['fr_email'] =$email;
        if(isset($_POST['regulamin'])) $_SESSION['fr_regulamin'] =true;







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
                //czy email juz istnieje
                $rezultat =$polaczenie->query("SELECT id_klienta FROM klient WHERE email='$email'");

                if(!$rezultat) throw new Exception($polaczenie->error);

                $ile_takich_maili = $rezultat->num_rows;
                if($ile_takich_maili>0)
                {
                    $wszystko_OK=false;
                    $_SESSION['e_email']="Istnieje już konto przypisane do tego adresu email!";
                }



                //czy login jest juz zarezerwowany
                $rezultat =$polaczenie->query("SELECT id_klienta FROM klient WHERE login='$login'");

                if(!$rezultat) throw new Exception($polaczenie->error);

                $ile_takich_loginow = $rezultat->num_rows;
                if($ile_takich_loginow>0)
                {
                    $wszystko_OK=false;
                    $_SESSION[e_login]="Istnieje już użytkownik o takim loginie!";
                }



                        if($wszystko_OK == true)
                            {
                              if($polaczenie->query("INSERT INTO `klient` (`id_klienta`, `imie`, `nazwisko`, `email`, `login`, `haslo`, `wiek`) VALUES (NULL, '$imie', '$nazwisko', '$email', '$login', '$haslo_hash', '$wiek')"))
                              {
                                $_SESSION['udanarejestracja']=true;
                                header('Location: powitanie.php');          // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< przeniesienie na strone po rejestracji
                              }
                              else
                              {

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

	<h1>Rejestracja nowego użytkownika</h1>

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
    Email: <input type="text" value="<?php
    if(isset($_SESSION['fr_email']))
        echo $_SESSION['fr_email'];
        unset($_SESSION['fr_email']);
    ?>" name="email"/><br/>
    <?php
        if(isset($_SESSION['e_email']))
        {
            echo '<div class="error">'.$_SESSION['e_email'].'</div>';
            unset($_SESSION['e_email']);
        }
    ?>
    Wiek: <input type="text" value="<?php
    if(isset($_SESSION['fr_wiek']))
        echo $_SESSION['fr_wiek'];
        unset($_SESSION['fr_wiek']);
    ?>" name="wiek"/><br/>
    <?php
        if(isset($_SESSION['e_wiek']))
        {
            echo '<div class="error">'.$_SESSION['e_wiek'].'</div>';
            unset($_SESSION['e_wiek']);
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

    <label>
        <input type="checkbox" name="regulamin" <?php
        if(isset($_SESSION['fr_regulamin']))
        {
            echo "checked";
            unset($_SESSION['fr_regulamin']);
        }
        
        
        ?> /> Akceptuję regulamin
    </label>
    <?php
        if(isset($_SESSION['e_regulamin']))
        {
            echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
            unset($_SESSION['e_regulamin']);
        }
    ?>

    <div class="g-recaptcha" data-sitekey="6LcWgH8UAAAAAAfKCz3wSOpP_KNjIxNmieTMKkAf"></div>
    <?php
        if(isset($_SESSION['e_bot']))
        {
            echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
            unset($_SESSION['e_bot']);
        }
    ?>

    <br/>
    <input type="submit" value="Zarejestruj się"/>



</form>



</body>
</html>