<?php

$nazwa = $_POST["nazwa"];
$iloscJM = $_POST["iloscJM"];

require_once "conect.php";
$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

if ($polaczenie->connect_errno) {
    echo json_encode(["error" => "Błąd połączenia: " . $polaczenie->connect_error]);
    exit();
}

$nazwa = $polaczenie->real_escape_string($nazwa);
$iloscJM = (float) $iloscJM;

$sql = "SELECT * FROM asortyment WHERE asortyment='$nazwa'";
$rezultat = $polaczenie->query($sql);

$response = [];

if ($rezultat) {
    if ($rezultat->num_rows > 0) {
        while ($obj = $rezultat->fetch_object()) {
            $iloscPaleta = $obj->iloscPaleta;
            $waga = $obj->waga;
            $czasProdukcji = $obj->czasProdukcji; // Zakładamy format HH:MM:SS

            // Konwersja czasu na sekundy
            list($hours, $minutes, $seconds) = explode(':', $czasProdukcji);
            $timeInSeconds = $hours * 3600 + $minutes * 60 + $seconds;

            // Obliczenie liczby sztuk i całkowitego czasu
            // $ileSztuk = round($a * $l, 2);
            $totalTimeInSeconds = $timeInSeconds * $iloscJM;
            $wagaTotal  = round($iloscJM * $waga, 2);

            // Konwersja całkowitego czasu z powrotem na format HH:MM:SS
            $hours = floor($totalTimeInSeconds / 3600);
            $minutes = floor(($totalTimeInSeconds % 3600) / 60);
            $seconds = $totalTimeInSeconds % 60;
            $czasP = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

            // Dodanie wyników do tablicy odpowiedzi
            $response[] = [
                "Index1" => round($iloscJM/$iloscPaleta,2),
                "Index2" => $czasP, // Całkowity czas w formacie HH:MM:SS
                "Index3" => $wagaTotal, // Całkowity czas w formacie HH:MM:SS
            ];
        }
    } else {
        $response = ["error" => "Brak wyników dla NAZWA = '$nazwa'."];
    }
} else {
    $response = ["error" => "Nie udało się wykonać zapytania: " . $polaczenie->error];
}

$polaczenie->close();

// Zwracamy odpowiedź w formacie JSON
header('Content-Type: application/json');
echo json_encode($response);
?>

