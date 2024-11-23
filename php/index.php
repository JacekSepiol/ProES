<?php
session_start();
if(isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany']==true))
{
  header('Location: Admin.php');
  exit();
}
?>

<!DOCTYPE html>

<html lang="pl">
  <head>
    <meta charset="utf-8" />
    <title>ProES ver.3.2</title>

    <link rel="stylesheet" href="../css/formularz.css" type="text/css" />
    <script src="js/timer.js"></script>
  </head>

  <body>
    <div id="conteiner">
        <form action="zaloguj.php" method="post">
            <input type="text" name="login" placeholder="Login" 
                onfocus= "this.placeholder=''" 
                onblur = "this.placeholder='Login'"/>
            <input type="password" name="haslo" placeholder="Hasło"
                onfocus= "this.placeholder=''" 
                onblur = "this.placeholder='Hasło'"/>
     
            <input type="submit" value="Zaloguj się!"/><br/>

                <?php
                if(isset($_SESSION['blad']))

                echo $_SESSION['blad'];
                ?>

      </form>
    </div>
  </body>
</html>
