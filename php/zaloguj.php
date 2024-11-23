<?php
session_start();

require_once "conect.php";

$polaczenie=new mysqli($host,$db_user,$db_password,$db_name);

if($polaczenie->connect_errno!=0)
        {
          echo "Error:".$polaczenie->connect_errno;
        }
else
{
  //wczytanie zmiennych przesłanych metodą POST
  $login=$_POST['login'];
  $haslo=$_POST['haslo'];

//zamiana na encje html
  $login=htmlentities($login,ENT_QUOTES,"UTF-8");
  $haslo=htmlentities($haslo,ENT_QUOTES,"UTF-8");

 
//i jeszcze przepuszczemy to przez funkcje SPRINTF z dwoma argumentami jak poniżej...
if ($rezultat=$polaczenie->query(sprintf("SELECT*FROM uzytkownicy WHERE 
        login='%s' AND 
        haslo='%s'", 
            mysqli_real_escape_string($polaczenie,$login),
            mysqli_real_escape_string($polaczenie,$haslo))))

{
      $ilu_userow=$rezultat->num_rows;
          if($ilu_userow>0)
        {
              $_SESSION['zalogowany']=true;

              $wiersz=$rezultat->fetch_assoc();
                    $_SESSION['user']=$wiersz['login'];
                    $_SESSION['id_user']=$wiersz['id_user'];
            
              unset($_SESSION['blad']);

              $rezultat->close();
              header('Location:Admin.php');
        }
        else{
          $_SESSION['blad']='<span style="color:red;">Nieprawidłowy Login lub Hasło!</span>';
          header('Location:index.php');
        }
}

$polaczenie->close();
}



?>
