
<?php
session_start();
if(!isset($_SESSION['zalogowany']))
{
  header('Location:index.php');
  exit();
}
?>

<!DOCTYPE html>

<html lang="pl">
  <head>
    <meta charset="utf-8" />
    <title>ProES ver.3.2</title>

    <link rel="stylesheet" href="../css/main3_2.css" type="text/css" />
    <link rel="stylesheet" href="../css/administrator.css" type="text/css" />
    <script src="../js/timer.js"></script>
  </head>

  <body onload="odliczanie()";>

    <div id="container">
      <div id="logo">
              <div id="logoGam"><img src="../img/Gamrat LOGO1.jpg" width="200" height="50" /></div>
              <div id="witaj">
                      <?php
                      echo "<p> Witaj: ".$_SESSION['user'].' ! <a href="logout.php">[Wyloguj się!]</a></p>';
                      ?>
              </div>
              <div id="panel"><h1>Panel: ADMINISTRATOR</h1></div>
              <div id="zegar">Poniedziałek, 28.05.2024</div>
              <div id="Proes"><img src="../img/ProES200.jpg" width="200" height="50" /></div>
          </div>
          <div style="clear: both;"></div>

         <div id="menu">
            <a href="Admin.php"><div class="option" id="admin"><img src="../img/Admin350.jpg" width="130" /></div></a>
            <a href="Planowanie.php"><div class="option"><img src="../img/Planowanie350.jpg" width="130" /></div></a>
            <a href="Produkcja.php"><div class="option"><img src="../img/Produkcja350.jpg" width="130" /></div></a>
            <a href="UR.php"><div class="option"><img src="../img/UR350.jpg" width="130" /></div></a>
            <a href="Raporty.php"><div class="option"><img src="../img/Raporty350.jpg" width="130" /></div></a>
            <a href="Kadry.php"><div class="option"><img src="../img/Kadry350.jpg" width="130" /></div></a>
            <a href="Jakosc.php"><div class="option"><img src="../img/Jakosc350.jpg" width="130" /></div></a>
            <a href="Rozne.php"><div class="option"><img src="../img/Rozne350.jpg" width="130" /></div></a>
            <div style="clear: both";></div>
        </div>

        <div id="tresc">
            <a href="ZmianaHasla.php"><input class="dodaj" type="button" value="Zmiana HASŁA"/></a>
            <a href="DodajUzytkownika.php"><input class="dodaj" type="button" value="Dodaj użytkownika"/></a>
        </div>

        <div style="clear: both";></div>

       <div id="stopka">~ ProES System ~ Wszelkie prawa zastrzeżone &copy; 2024</div>
    </div>
  </body>
</html>
