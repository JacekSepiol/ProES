<?php
session_start();
if (!isset($_SESSION['zalogowany'])) {
  header('Location:index.php');
  exit();
}
?>

<?php
$rezultat = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Dywizja'])) {
  $dywizja = $_POST['Dywizja'];
  $tydzien = $_POST['Tydzien'] ?? '';
  $kolor = $_POST['Kolor'] ?? '';
  $rozmiar = $_POST['Rozmiar'] ?? '';
  $slowo = $_POST['Slowo'] ?? '';

  require_once "conect.php";
  $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

  if ($polaczenie->connect_errno) {
    echo "Error: " . $polaczenie->connect_error;
  } else {
    $query = "SELECT * FROM asortyment WHERE dywizja = '$dywizja' 
                  AND asortyment LIKE '%$rozmiar%' 
                  AND kolor LIKE '%$kolor%' 
                  AND asortyment LIKE '%$slowo%'";
    $rezultat = $polaczenie->query($query);
    $polaczenie->close();
  }
}
?>

<!DOCTYPE html>

<html lang="pl">

<head>
  <meta charset="utf-8" />
  <title>ProES ver.3.2</title>


  <link rel="stylesheet" href="../css/main3_2.css?php echo time(); ?>">
  <link rel="stylesheet" href="../css/dodajTabelePlanu.css?php echo time(); ?>">

  <script src="../js/timer.js"></script>

</head>

<body onload="odliczanie()" ;>

  <div id="container">
    <div id="logo">
      <div id="logoGam"><img src="../img/Gamrat LOGO1.jpg" width="200" height="50" /></div>
      <div id="witaj">
        <?php
        echo "<p> Witaj: " . $_SESSION['user'] . ' ! <a href="logout.php">[Wyloguj się!]</a></p>';
        ?>
      </div>
      <div id="panel">
        <h1>Panel: PLANOWANIE</h1>
      </div>
      <div id="zegar">Poniedziałek, 28.05.2024</div>
      <div id="Proes"><img src="../img/ProES200.jpg" width="200" height="50" /></div>
    </div>
    <div style="clear: both;"></div>

    <div id="menu">

      <a href="Admin.php">
        <div class="option" id="admin">
          <img src="../img/Admin350.jpg" width="130" />
        </div>
      </a>

      <a href="Planowanie.php">
        <div class="option">
          <img src="../img/Planowanie350.jpg" width="130" />
        </div>
      </a>

      <a href="Produkcja.php">
        <div class="option">
          <img src="../img/Produkcja350.jpg" width="130" />
        </div>
      </a>

      <a href="UR.php">
        <div class="option">
          <img src="../img/UR350.jpg" width="130" />
        </div>
      </a>

      <a href="Raporty.php">
        <div class="option">
          <img src="../img/Raporty350.jpg" width="130" />
        </div>
      </a>

      <a href="Kadry.php">
        <div class="option">
          <img src="../img/Kadry350.jpg" width="130" />
        </div>
      </a>

      <a href="Jakosc.php">
        <div class="option">
          <img src="../img/Jakosc350.jpg" width="130" />
        </div>
      </a>

      <a href="Rozne.php">
        <div class="option">
          <img src="../img/Rozne350.jpg" width="130" />
        </div>
      </a>
      <div style="clear: both"></div>
    </div>

    <div id="tresc">

      <form method="post" id="planSzukaj">
        <div id="Dywizja">
          <label><input type="radio" name="Dywizja" value="WTRY"
              <?php
              if (isset($dywizja) and ($dywizja == "WTRY"))
                echo "checked";
              ?> />WTRYSK</label>

          <label><input type="radio" name="Dywizja" value="WYTL"
              <?php
              if (isset($dywizja) and ($dywizja == "WYTL"))
                echo "checked";
              ?> />WYTŁACZANIE</label>
        </div>

        <div id="Week">
          <label>NUMER TYGODNIA:
            <input type="number" name="Tydzien" min="1" max="53" id="Indeks">
          </label>
        </div>

        <div>
          <label for="GO"><input type="submit" id="GO" name="GO" value="ZATWIERDŹ PLAN" name="GO"></label>
        </div>

        <div style="clear: both"></div>

        <fieldset>
          <legend>Pola wyszukujące Asortyment</legend>

          <label for="Kolor">Kolor/Wzór</label>
          <select id="Kolor" name="Kolor">
            <option></option>
            <option value="CBR">CBR</option>
            <option value="GRF">GRF</option>
            <option value="BIA">BIA</option>
            <option value="CZA2">CZA2</option>
            <option value="MIE">MIE</option>
            <option value="SRE">SRE</option>
            <option value="BR">BR</option>
            <option value="POP">POP</option>
            <option value="CEG">CEG</option>
            <option value="ORZ">ORZ</option>
            <option value="ZLD">ZŁOTY</option>
            <option value="WIN">WIN</option>
            <option value="MAH">MAH</option>
          </select>

          <label for="Rozmiar">Rozmiar/Typ</label>
          <select id="Rozmiar" name="Rozmiar">
            <option></option>
            <option value="63">63</option>
            <option value="75">75</option>
            <option value="90">90</option>
            <option value="100">100</option>
            <option value="110">110</option>
            <option value="125">125</option>
            <option value="128">128</option>
            <option value="150">150</option>
            <option value="LISTWA">LISTWA</option>
            <option value="PEŁNA">PEŁNA</option>
            <option value="PERFO">PERFO</option>
            <option value="RURA">RURA</option>
            <option value="RYNNA">RYNNA</option>
          </select>

          <label for="Slowo">Słowo kluczowe:</label>
          <input type="search" name="Slowo" id="Slowo" />

          <input type="submit" id="szukaj" value="Szukaj..." class="szukaj" />

        </fieldset>
      </form>


      <div id="ASORT" class="wybor">
        <label for="Asortyment">ASORTYMENT</label>
        <select id="Asortyment" name="Asortyment">
          <option value=""></option>
          <?php
          while ($obj = $rezultat->fetch_object()) {

            $k = $obj->asortyment;
            // $i=$obj->INDEKS;

            echo '<option value="' . $k . '"' . '>' . $k . '</option>';
          }

          ?>

        </select>
      </div>
      <div class="wybor">
        <label for="indeks">INDEKS</label>
        <input type="text" name="indeks" id="indeks" disabled />
      </div>

      <div class="wybor">
        <label for="mozliweLinie">LINIA</label>
        <select id="mozliweLinie">
          <!-- Opcje zostaną tutaj dodane dynamicznie -->
        </select>
      </div>


      <div class="wybor">
        <label for="iloscJM">ILOŚĆ [j.m.]</label>
        <input type="number" name="iloscJM" id="iloscJM" min="0">
      </div>


      <div class="wybor">
        <label for="iloscP">ILOŚĆ PALET </label>
        <input type="number" name="iloscP" id="iloscP" step="0.1" min="0" disabled>
      </div>


      <div class="wybor">
        <label for="Czas">CZAS PROD.</label>
        <input type="text" id="Czas" name="Czas" disabled>
      </div>

      <div class="wybor">
        <label for="Start">START PRODUKCJI</label>
        <input type="date" id="startDate" name="startDate">
        <input type="time" id="startTime" name="startTime">
      </div>

      <div class="wybor">
        <label for="Stop">STOP PRODUKCJI</label>
        <input type="date" id="stopDate" name="stopDate" disabled>
        <input type="time" id="stopTime" name="stopTime" disabled>
      </div>

      <div class="wybor">
        <label for="Waga">WAGA </label>
        <input type="text" id="Waga" name="Waga" disabled>
      </div>

      <div class="wybor">
        <label for="dodajPozycjePlanu"></label>
        <input class="szukaj" type="submit" id="dodajPozycjePlanu" name="dodajPozycjePlanu" value="Dodaj...">
      </div>
      <div style="clear: both"></div>


      <table id="tabelaPlanu" class="ukryta">
        <thead>
          <tr>
            <th data-sort="">Linia</th>
            <th data-sort="">Asortyment</th>
            <th data-sort="">Indeks</th>
            <th data-sort="">Ilość [j.m.]</th>
            <th data-sort="">Ilość Palet</th>
            <th data-sort="">Start Produkcji</th>
            <th data-sort="">Stop Produkcji</th>
            <th data-sort="">Waga</th>
            <th>Akcje</th> <!-- Kolumna dla przycisków "Usuń" i "Popraw" -->
          </tr>
        </thead>
        <tbody>
          <!-- Wiersze tabeli będą dodawane dynamicznie -->
        </tbody>
      </table>


    </div>


    <div id="stopka">
      ~ ProES System ~ Wszelkie prawa zastrzeżone &copy; 2024
    </div>
  </div>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


  <script src="../js/pobierzDane.js"></script>
  <script src="../js/stopProdukcjiPlan.js"></script>
  <script src="../js/dodajTabelePlanu.js"></script>
  <script src="../js/szukaj.js"></script>

</body>

</html>