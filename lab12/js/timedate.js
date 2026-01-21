// ==================================================
// FUNKCJA POKAZUJĄCA AKTUALNĄ DATĘ
// ==================================================
function gettheDate() {
    // Pobranie aktualnej daty z systemu
    var Todays = new Date();

    // Składanie daty w formacie M / D / YY
    // getMonth() zwraca miesiące 0-11, dlatego +1
    // getYear() zwraca lata od 1900, więc odejmujemy 100 dla dwóch ostatnich cyfr
    var TheDate = "" + (Todays.getMonth() + 1) + " / " + Todays.getDate() + " / " + (Todays.getYear() - 100);

    // Wstawienie daty do elementu HTML o id="data"
    document.getElementById("data").innerHTML = TheDate;
}

// ==================================================
// ZMIENNE GLOBALNE DLA ZEGARKA
// ==================================================
var timerID = null;       // ID timera dla setTimeout
var timerRunning = false; // Flaga, czy zegarek działa

// ==================================================
// FUNKCJA ZATRZYMUJĄCA ZEGAREK
// ==================================================
function stopclock() {
    // Jeśli zegarek działa, zatrzymujemy timer
    if (timerRunning) clearTimeout(timerID);
    timerRunning = false; // ustawienie flagi na false
}

// ==================================================
// FUNKCJA URUCHAMIAJĄCA ZEGAREK
// ==================================================
function startclock() {
    stopclock();     // zatrzymanie istniejącego zegarka
    gettheDate();    // ustawienie aktualnej daty
    showtime();      // uruchomienie aktualnego czasu
}

// ==================================================
// FUNKCJA WYŚWIETLAJĄCA CZAS
// ==================================================
function showtime() {
    var now = new Date();           // pobranie aktualnego czasu
    var hours = now.getHours();     // godziny w formacie 0-23
    var minutes = now.getMinutes(); // minuty
    var seconds = now.getSeconds(); // sekundy

    // Formatowanie godzin w 12-godzinnym formacie
    var timeValue = "" + ((hours > 12) ? hours - 12 : hours);

    // Dodanie minut z wiodącym zerem jeśli <10
    timeValue += ((minutes < 10) ? ":0" : ":") + minutes;

    // Dodanie sekund z wiodącym zerem jeśli <10
    timeValue += ((seconds < 10) ? ":0" : ":") + seconds;

    // Dodanie oznaczenia AM/PM
    timeValue += (hours >= 12) ? " P.M." : " A.M.";

    // Wstawienie czasu do elementu HTML o id="zegarek"
    document.getElementById("zegarek").innerHTML = timeValue;

    // Ustawienie timera na ponowne wywołanie funkcji co 1 sekundę
    timerID = setTimeout("showtime()", 1000);
    timerRunning = true; // ustawienie flagi zegarka na true
}
