function calculateStopTime() {
	const startDate = document.getElementById("startDate").value;
	const startTime = document.getElementById("startTime").value;
	const czasField = document.getElementById("Czas").value;

	if (!startDate || !startTime || !czasField) {
		console.warn(
			"Brak danych wejściowych do obliczeń (startDate, startTime, czas)."
		);
		return;
	}

	// Konwersja daty w formacie YYYY-MM-DD
	const dateParts = startDate.split("-");
	const startYear = parseInt(dateParts[0], 10);
	const startMonth = parseInt(dateParts[1], 10) - 1; // JavaScript months are zero-indexed
	const startDay = parseInt(dateParts[2], 10);

	// Konwersja czasu w formacie HH:mm:ss
	const timeParts = startTime.split(":");
	const startHour = parseInt(timeParts[0], 10);
	const startMinute = parseInt(timeParts[1], 10);

	const czasParts = czasField.split(":");
	const prodHours = parseInt(czasParts[0], 10);
	const prodMinutes = parseInt(czasParts[1], 10);
	const prodSeconds = parseInt(czasParts[2], 10);

	// Tworzenie obiektu daty początkowej
	const startDateTime = new Date(
		startYear,
		startMonth,
		startDay,
		startHour,
		startMinute
	);
	if (isNaN(startDateTime)) {
		console.error("Błąd podczas parsowania daty początkowej.");
		return;
	}

	// Dodawanie czasu produkcji
	startDateTime.setHours(startDateTime.getHours() + prodHours);
	startDateTime.setMinutes(startDateTime.getMinutes() + prodMinutes);
	startDateTime.setSeconds(startDateTime.getSeconds() + prodSeconds);

	// Ustawianie daty i czasu stopu
	const stopYear = startDateTime.getFullYear();
	const stopMonth = String(startDateTime.getMonth() + 1).padStart(2, "0");
	const stopDay = String(startDateTime.getDate()).padStart(2, "0");
	const stopHours = String(startDateTime.getHours()).padStart(2, "0");
	const stopMinutes = String(startDateTime.getMinutes()).padStart(2, "0");

	document.getElementById(
		"stopDate"
	).value = `${stopYear}-${stopMonth}-${stopDay}`;
	document.getElementById("stopTime").value = `${stopHours}:${stopMinutes}`;
}

// Funkcja nasłuchująca zmiany w polu "Czas"
function watchCzas() {
	const czasField = document.getElementById("Czas");
	let lastValue = czasField.value;

	setInterval(() => {
		if (czasField.value !== lastValue) {
			lastValue = czasField.value;
			calculateStopTime();
		}
	}, 200); // Sprawdzenie co 200 ms
}

// Funkcja nasłuchująca zmiany w polach startDate i startTime
function watchStartFields() {
	document
		.getElementById("startDate")
		.addEventListener("input", calculateStopTime);
	document
		.getElementById("startTime")
		.addEventListener("input", calculateStopTime);
}

// Uruchamianie funkcji nasłuchujących
watchCzas();
watchStartFields();
