document.addEventListener("DOMContentLoaded", function () {
	const dodajBtn = document.getElementById("dodajPozycjePlanu");
	const tabela = document.getElementById("tabelaPlanu");
	const tbody = tabela.querySelector("tbody");
	const goBtn = document.getElementById("Go");

	let tabelaDane = JSON.parse(localStorage.getItem("tabelaDane")) || [];

	// Odtwarzanie tabeli na podstawie danych w localStorage
	function odtworzTabele() {
		tbody.innerHTML = ""; // Wyczyść istniejące wiersze
		tabelaDane.forEach((wiersz) => {
			dodajWierszDoTabeli(wiersz);
		});

		// Pokazuj tabelę tylko, jeśli są dane
		if (tabelaDane.length > 0) {
			tabela.classList.remove("ukryta");
		} else {
			tabela.classList.add("ukryta");
		}
	}

	// Dodawanie wiersza do tabeli
	function dodajWierszDoTabeli({
		linia,
		asortyment,
		indeks,
		iloscJM,
		iloscP,
		startDate,
		startTime,
		stopDate,
		stopTime,
		waga,
	}) {
		const row = document.createElement("tr");
		row.innerHTML = `
            <td>${linia}</td>
            <td>${asortyment}</td>
            <td>${indeks}</td>
            <td>${iloscJM}</td>
            <td>${iloscP}</td>
            <td>${startDate} ${startTime}</td>
            <td>${stopDate} ${stopTime}</td>
            <td>${waga}</td>
            <td>
                <button class="button popraw">Popraw</button>
                <button class="button usun">Usuń</button>
            </td>
        `;

		// Obsługa przycisku "Usuń"
		row.querySelector(".usun").addEventListener("click", function () {
			tabelaDane = tabelaDane.filter((item) => item.indeks !== indeks);
			zapiszTabeleDoLocalStorage();
			odtworzTabele();
		});

		// Obsługa przycisku "Popraw"
		row.querySelector(".popraw").addEventListener("click", function () {
			poprawWiersz(row);
		});

		tbody.appendChild(row);
	}

	// Zapisywanie danych tabeli do localStorage
	function zapiszTabeleDoLocalStorage() {
		localStorage.setItem("tabelaDane", JSON.stringify(tabelaDane));
	}

	// Obsługa przycisku "Dodaj"
	dodajBtn.addEventListener("click", function (event) {
		event.preventDefault();

		const linia = document.getElementById("mozliweLinie").value;
		const asortyment = document.getElementById("Asortyment").value || "Brak";
		const indeks = document.getElementById("indeks").value || "Brak";
		const iloscJM = document.getElementById("iloscJM").value;
		const iloscP = document.getElementById("iloscP").value || "0";
		const startDate = document.getElementById("startDate").value;
		const startTime = document.getElementById("startTime").value;
		const stopDate = document.getElementById("stopDate").value || "-";
		const stopTime = document.getElementById("stopTime").value || "-";
		const waga = document.getElementById("Waga").value || "-";

		if (!linia || !iloscJM || !startDate || !startTime) {
			alert("Proszę wprowadzić wszystkie wymagane dane!");
			return;
		}

		const nowyWiersz = {
			linia,
			asortyment,
			indeks,
			iloscJM,
			iloscP,
			startDate,
			startTime,
			stopDate,
			stopTime,
			waga,
		};
		tabelaDane.push(nowyWiersz);
		zapiszTabeleDoLocalStorage();
		odtworzTabele();
	});

	// Obsługa przycisku "Popraw"
	function poprawWiersz(row) {
		const cells = row.querySelectorAll("td");
		const linia = cells[0].innerText;
		const asortyment = cells[1].innerText;
		const indeks = cells[2].innerText;
		const iloscJM = cells[3].innerText;
		const iloscP = cells[4].innerText;
		const startDate = cells[5].innerText.split(" ")[0];
		const startTime = cells[5].innerText.split(" ")[1];
		const stopDate = cells[6].innerText.split(" ")[0];
		const stopTime = cells[6].innerText.split(" ")[1];
		const waga = cells[7].innerText;

		document.getElementById("mozliweLinie").value = linia;
		document.getElementById("Asortyment").value = asortyment;
		document.getElementById("indeks").value = indeks;
		document.getElementById("iloscJM").value = iloscJM;
		document.getElementById("iloscP").value = iloscP;
		document.getElementById("startDate").value = startDate;
		document.getElementById("startTime").value = startTime;
		document.getElementById("stopDate").value = stopDate;
		document.getElementById("stopTime").value = stopTime;
		document.getElementById("Waga").value = waga;
	}

	// Obsługa przycisku "Go"
	goBtn.addEventListener("click", function (event) {
		event.preventDefault();

		fetch("zapisz_plan.php", {
			method: "POST",
			headers: { "Content-Type": "application/json" },
			body: JSON.stringify(tabelaDane),
		})
			.then((response) => response.json())
			.then((data) => {
				alert("Plan został zapisany pomyślnie!");
				localStorage.removeItem("tabelaDane");
				tabelaDane = [];
				odtworzTabele();
			})
			.catch((error) => {
				alert("Błąd podczas zapisywania planu!");
				console.error(error);
			});
	});

	// Odtwórz tabelę przy załadowaniu strony
	odtworzTabele();
});
