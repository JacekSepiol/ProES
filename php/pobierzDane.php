<?php
// Pobranie wartości z POST pobierzDane.js AJAX'em
$nazwa = $_POST["nazwa"];

// Połączenie z bazą danych
require_once "conect.php";
$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

// Sprawdzamy, czy połączenie z bazą danych zakończyło się powodzeniem
if ($polaczenie->connect_errno) {
    http_response_code(500); // Ustawienie kodu błędu 500 dla serwera
    echo json_encode(["error" => "Błąd połączenia: " . $polaczenie->connect_error]);
    exit();
}

// Zabezpieczenie wejścia przed SQL injection
$nazwa = $polaczenie->real_escape_string($nazwa);

// Zapytanie do bazy danych
$sql = "SELECT * FROM asortyment WHERE asortyment='$nazwa'";
$rezultat = $polaczenie->query($sql);

// Przygotowanie odpowiedzi
$response = [];

// Sprawdzamy, czy zapytanie zwróciło wyniki
if ($rezultat && $rezultat->num_rows > 0) {
    $obj = $rezultat->fetch_object(); // Pobranie jednego wiersza jako obiekt
    
    // Tworzymy odpowiedź na podstawie zwróconych danych
    $response = [
        "Index" => $obj->indeks,
    ];

    // Iteracja po możliwych liniach (od 1 do 13)
    for ($i = 1; $i <= 13; $i++) {
        $key = "mozliwaLinia" . $i;
        if (!empty($obj->$key)) { // Dodajemy tylko niepuste wartości
            $response[$key] = $obj->$key;
        }
    }

    // Zwracamy dane w formacie JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Jeśli brak wyników, zwracamy pustą odpowiedź
    http_response_code(404);
    echo json_encode(["error" => "Nie znaleziono danych"]);
}

// Zamykamy połączenie z bazą danych
$polaczenie->close();
?>
