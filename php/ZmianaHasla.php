<?php
session_start();

if(isset($_POST['nowehaslo1']))
{
    $wszystko_OK = true;
    $nowehaslo1=$_POST['nowehaslo1'];
    $nowehaslo2=$_POST['nowehaslo2'];
      
    if (strlen($nowehaslo1)<5 || (strlen($nowehaslo1)>10))
      {
          $wszystko_OK = false;
          $_SESSION['e_haslo']= "Hasło musi posiadać od 5 do 10 znaków";
      }

    if (ctype_alnum($nowehaslo1)==false)
      {
          $wszystko_OK = false;
          $_SESSION['e_haslo']= "Hasło może składać się tylko z liter i cyfr bez polskich znaków";
      }

    if($nowehaslo1!=$nowehaslo2)
      {
          $wszystko_OK = false;
          $_SESSION['e_haslo']= "Podane HASŁA nie są identyczne";
      }
      
 

    
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
            $id =$_SESSION['id_user'];
          
            if($wszystko_OK==true)
            {

              if($rezultat=$polaczenie->query("UPDATE uzytkownicy SET haslo='$nowehaslo1' where id_user='$id'"))
                {
                  $_SESSION['nowehaslo']="Hasło zostało zmienione!";
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
    <title>ProES ver.3.0</title>

    <link rel="stylesheet" href="../css/formularz.css" type="text/css" />
    <script src="../js/timer.js"></script>

    <style>
      .error
      {
        color:red;
        margin-top: 15px;
        margin-bottom: 5px;
        text-align: center;
      }
      .noweHaslo
      {
        color:green;
        margin-top: 15px;
        margin-bottom: 5px;
        text-align: center;
      }
    </style>
  </head>

  <body>
    <div id="formularz">
      <form  method="post" >
         <div id="conteiner">
                Nowe Hasło:<br/>
                <input type="password" name="nowehaslo1"/><br/>

                Powtórz Nowe Hasło:<br/>
                <input type="password" name="nowehaslo2"/><br/>
                      
                      <?php
                        if(isset($_SESSION['e_haslo']))
                            {
                              echo '<div class="error">'.$_SESSION['e_haslo']."</div>";
                              unset($_SESSION['e_haslo']);
                            }
                      ?>

                        <br/>

                <input class="dodaj" type="submit" value="Zmień hasło"/>
                      
                      <?php
                      if(isset($_SESSION['nowehaslo']))
                          {
                            echo '<div class="noweHaslo">'.$_SESSION['nowehaslo']."</div>";
                            unset($_SESSION['nowehaslo']);
                          }
                      ?>
  
   
                <a href="Admin.php"><input id="dodaj" class="dodaj" type="button" value="Powrót do strony głównej"/></a>
            </div>
        </form>
   </div>

  </body>
</html>
