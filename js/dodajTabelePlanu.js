document.addEventListener("DOMContentLoaded", function () {
	const tabela = document.getElementById("tabelaPlanu");
	const tbody = tabela.querySelector("tbody");
	const dodajPozycjePlanu = document.getElementById("dodajPozycjePlanu");
	const asortymentSelect = document.getElementById("Asortyment");

	let tabelaDane = []; // Przechowuje dane tabeli
	let edytowanyIndex = null; // Indeks wiersza, który jest aktualnie edytowany

	// Funkcja aktualizująca tabelę na podstawie danych
	function odtworzTabele(dane) {
		tbody.innerHTML = ""; // Wyczyść tabelę
		dane.forEach((wiersz, index) => {
			const row = document.createElement("tr");
			row.innerHTML = `
                <td>${wiersz.mozliweLinie || ""}</td>
                <td>${wiersz.Asortyment || ""}</td>
                <td>${wiersz.indeks || ""}</td>
                <td>${wiersz.iloscJM || ""}</td>
                <td>${wiersz.iloscP || ""}</td>
                <td>${wiersz.startDate || ""} ${wiersz.startTime || ""}</td>
                <td>${wiersz.stopDate || ""} ${wiersz.stopTime || ""}</td>
                <td>${wiersz.Waga || ""}</td>
                <td>
                    <button data-index="${index}" class="usun">Usuń</button>
                    <button data-index="${index}" class="popraw">Popraw</button>
                </td>
            `;
			tbody.appendChild(row);
		});

		tabela.classList.toggle("ukryta", dane.length === 0); // Pokaż tabelę, jeśli są dane
	}

	// Obsługa przycisku "Usuń"
	tbody.addEventListener("click", function (e) {
		if (e.target.classList.contains("usun")) {
			console.log("hehe");
			const index = parseInt(e.target.getAttribute("data-index"), 10);
			tabelaDane.splice(index, 1); // Usuń tylko wskazany wiersz
			odtworzTabele(tabelaDane); // Odtwórz tabelę
		}

		// Obsługa przycisku "Popraw"
		if (e.target.classList.contains("popraw")) {
			const index = parseInt(e.target.getAttribute("data-index"), 10);
			const wiersz = tabelaDane[index];
			edytowanyIndex = index; // Zapisz indeks edytowanego wiersza

			// Wypełnij formularz danymi z wybranego wiersza
			document.getElementById("mozliweLinie").value = wiersz.mozliweLinie || "";
			document.getElementById("Asortyment").value = wiersz.Asortyment || ""; // Dodano poprawnie Asortyment
			document.getElementById("indeks").value = wiersz.indeks || "";
			document.getElementById("iloscJM").value = wiersz.iloscJM || "";
			document.getElementById("iloscP").value = wiersz.iloscP || "";
			document.getElementById("startDate").value = wiersz.startDate || "";
			document.getElementById("startTime").value = wiersz.startTime || "";
			document.getElementById("stopDate").value = wiersz.stopDate || "";
			document.getElementById("stopTime").value = wiersz.stopTime || "";
			document.getElementById("Waga").value = wiersz.Waga || "";
		}
	});

	// Obsługa przycisku "Dodaj"
	dodajPozycjePlanu.addEventListener("click", function (e) {
		e.preventDefault();

		console.log("dodaj");

		const nowyWiersz = {
			linia: document.getElementById("mozliweLinie").value,
			asortyment: asortymentSelect.value,
			indeks: document.getElementById("indeks").value,
			iloscJM: document.getElementById("iloscJM").value,
			iloscPalet: document.getElementById("iloscP").value,
			startDate: document.getElementById("startDate").value,
			startTime: document.getElementById("startTime").value,
			stopDate: document.getElementById("stopDate").value,
			stopTime: document.getElementById("stopTime").value,
			waga: document.getElementById("Waga").value,
		};

		// Walidacja danych
		if (!nowyWiersz.linia || !nowyWiersz.asortyment || !nowyWiersz.iloscJM) {
			alert("Uzupełnij wszystkie dane");
			return;
		}

		if (edytowanyIndex !== null) {
			// Zapisz zmiany w istniejącym wierszu
			tabelaDane[edytowanyIndex] = nowyWiersz;
			edytowanyIndex = null; // Zresetuj tryb edycji
		} else {
			// Dodaj nowy wiersz
			tabelaDane.push(nowyWiersz);
		}

		odtworzTabele(tabelaDane); // Zaktualizuj tabelę
	});
});
