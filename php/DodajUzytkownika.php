<?php
session_start();

if(isset($_POST['login1']))
{
  $wszystko_OK = true;
  $login1=$_POST['login1'];
  $login1=str_replace(" ","",$login1);
            
          if (strlen($login1)<4 || (strlen($login1)>10))
            {
                $wszystko_OK = false;
                $_SESSION['e_login']= "Login musi posiadać od 5 do 10 znaków";
            }

          if (ctype_alnum($login1)==false)
            {
                $wszystko_OK = false;
                $_SESSION['e_login']= "Login może składać się tylko z liter i cyfr bez polskich znaków";
            }

          $login2=$_POST['login2'];
          $login2=str_replace(" ","",$login2);

          if($login1!=$login2)
            {
                $wszystko_OK = false;
                $_SESSION['e_login']= "Podane LOGINY nie są identyczne";
            }
            
          $haslo1=$_POST['haslo1'];
          $haslo2=$_POST['haslo2'];

          if (strlen($haslo1)<4 || (strlen($haslo1)>10))
            {
                $wszystko_OK = false;
                $_SESSION['e_haslo']= "Hasło musi posiadać od 5 do 10 znaków";
            }

          if (ctype_alnum($haslo1)==false)
            {
                $wszystko_OK = false;
                $_SESSION['e_haslo']= "Hasło może składać się tylko z liter i cyfr bez polskich znaków";
            }

          if($haslo1!=$haslo2)
            {
                $wszystko_OK = false;
                $_SESSION['e_haslo']= "Podane HASŁA nie są identyczne";
            }

$_SESSION['fr_login1']=$login1;
$_SESSION['fr_login2']=$login2;
$_SESSION['fr_haslo1']=$haslo1;
$_SESSION['fr_haslo2']=$haslo2;


require_once "conect.php";

      mysqli_report(MYSQLI_REPORT_STRICT);
try
  {
    $polaczenie=new mysqli($host,$db_user,$db_password,$db_name);
          
          if($polaczenie->connect_errno!=0)
            {
              throw new Exception(mysqli_connect_errno());
            }
            else
            {
        //czy login już istnieje
            $rezultat=$polaczenie->query("SELECT id_user FROM uzytkownicy WHERE login='$login1'");

          if(!$rezultat) throw new Exception($polaczenie->error);


        $ile_takich_userow=$rezultat->num_rows;

              if($ile_takich_userow>0)
              {
                $wszystko_OK = false;
                $_SESSION['e_login']= "Istnieje już taki LOGIN w bazie. Podaj inny!";
              }

        //czy Adnin o id=1 'id_user' przychodzi z zaloguj.php jak się zalogujesz to jest pobierane id

              if($_SESSION['id_user']>1){
                $wszystko_OK = false;
                $_SESSION['e_admin']= "Nie masz uprawnień do tej operacji!";

        }
        if($wszystko_OK==true)
        {
        
          //dopisujemy do bazy

        if($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL,'$login1','$haslo1')"))
        {
        $_SESSION['dodanouzytkownika']="Dodano nowego uzytkownika do bazy!";

        }
        else
        {

          throw new Exception(mysqli_connect_errno());
        }
        }

        $polaczenie->close();

            }

  }
catch(Exception $e)

{

  echo '<span style="color:red;">Błąd serwera!</span>';
  echo'<br/> Informacja deweloperska:'.$e;
}

   
}

?>

<!DOCTYPE html>

<html lang="pl">
  <head>
    <meta charset="utf-8" />
    <title>Dodaj użytkownika</title>

    <link rel="stylesheet" href="../css/formularz.css" type="text/css" />
    <script src="../js/timer.js"></script>

    <style>
      .error{
        color:red;
        margin-top: 5px;
        margin-bottom: 5px;
      }
    </style>
  </head>

  <body>
    <div id="conteiner">
        <form  method="post" >
          Login:<input type="text" value="
            <?php
              if(isset($_SESSION['fr_login1']))
                {
                  echo $_SESSION['fr_login1'];
                  unset($_SESSION['fr_login1']);
                }
            ?>
      " name="login1" />

<?php
    if(isset($_SESSION['e_login']))
      {
        echo '<div class="error">'.$_SESSION['e_login']."</div>";
        unset($_SESSION['e_login']);
      }
?>
    Powtórz Login:<br/><input type="text" value="<?php
    if(isset($_SESSION['fr_login2']))
    {
      echo $_SESSION['fr_login2'];
      unset($_SESSION['fr_login2']);
    }
    ?>
        
    "name="login2"/><br/>
    <br/>Hasło:<br/><input type="password" name="haslo1"/><br/>
    
<?php
    if(isset($_SESSION['e_haslo']))
    {
      echo '<div class="error">'.$_SESSION['e_haslo']."</div>";
      unset($_SESSION['e_haslo']);
    }
?>

    Powtórz Hasło:<br/><input type="password" name="haslo2"/><br/>
    <?php
    if(isset($_SESSION['dodanouzytkownika']))
    {
      echo '<div class="error">'.$_SESSION['dodanouzytkownika']."</div>";
      unset($_SESSION['dodanouzytkownika']);
    }
?>
    <br/><input class="dodaj" type="submit" value="Dodaj Użytkownika"/>
    <?php
    if(isset($_SESSION['e_admin']))
    {
      echo '<div class="error">'.$_SESSION['e_admin']."</div>";
      unset($_SESSION['e_admin']);
    }
?>
   
<a href="Admin.php"><input class="dodaj" type="button" value="Powrót do strony głównej"/></a>


</form>
  </div>


  </body>
</html>
