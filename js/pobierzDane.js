document.getElementById("Asortyment").addEventListener("change", podaj);
document.getElementById("iloscJM").addEventListener("change", podajJM);

function podaj() {
	// Pobranie wartości z selecta
	let nazwa = document.getElementById("Asortyment").value;

	console.log("podaj");
	// Wysłanie danych do PHP za pomocą AJAX
	$.ajax({
		url: "../php/pobierzDane.php",
		method: "POST",
		data: {
			nazwa: nazwa,
		},
		dataType: "json",
		success: function (response) {
			// Wpisanie indeksu do pola tekstowego
			document.getElementById("indeks").value = response.Index;

			// Czyszczenie poprzednich opcji w select
			let selectLinia = document.getElementById("mozliweLinie");
			selectLinia.innerHTML = "";

			// Iteracja po możliwych liniach i dodanie ich do select
			for (let i = 1; i <= 13; i++) {
				let linia = response[`mozliwaLinia${i}`];
				if (linia) {
					// Jeśli linia istnieje, dodaj ją jako opcję
					let option = document.createElement("option");
					option.value = linia;
					option.textContent = linia;
					selectLinia.appendChild(option);
				}
			}
		},
		error: function (xhr, status, error) {
			console.error("Wystąpił błąd:", error);
			console.error("Status:", status);
			console.error("Odpowiedź serwera:", xhr.responseText);
		},
	});
}

function podajJM() {
	// Pobranie wartości z selecta
	let nazwa = document.getElementById("Asortyment").value;
	let iloscJM = document.getElementById("iloscJM").value;

	// Wpisanie wartości do pola indeks

	// Wysłanie danych do PHP za pomocą AJAX

	$("#iloscJM").on("input blur change", function () {
		const iloscJM = this.value;
		// Jeśli masz dodatkowe dane, uzupełnij tutaj

		$.ajax({
			url: "../php/iloscJM.php",
			method: "POST",
			data: { nazwa, iloscJM },
			dataType: "json",
			success: function (response) {
				if (response.error) {
					console.error("Błąd: " + response.error);
				} else {
					document.getElementById("iloscP").value = response[0].Index1;
					document.getElementById("Waga").value = response[0].Index3;
					document.getElementById("Czas").value = response[0].Index2;

					calculateStopTime(); // Automatycznie przelicza stopDate i stopTime
				}
			},
			error: function (xhr, status, error) {
				console.error("Wystąpił błąd:", error);
			},
		});
	});
}
