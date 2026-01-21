// ==================================================
// ZMIENNE GLOBALNE
// ==================================================
var computed = false; // Flaga, czy ostatnia operacja została obliczona
var decimal = 0;      // Flaga, czy wprowadzono już znak dziesiętny (kropkę)

// ==================================================
// FUNKCJE KONWERSJI JEDNOSTEK
// ==================================================
function przeliczJednostki(entryform, form, to) {
    // Pobranie wybranej jednostki źródłowej i docelowej z list rozwijanych
    convertfrom = from.selectedIndex; // indeks jednostki wejściowej
    convertto = to.selectedIndex;     // indeks jednostki wyjściowej
    
    // Obliczenie przeliczenia: wartość wejściowa * wartość jednostki źródłowej / wartość jednostki docelowej
    entryform.display.value = (entryform.input.value * from[convertfrom].value / to[convertto].value);
}

// ==================================================
// FUNKCJA DODAWANIA ZNAKU (CYFRY LUB KROPKI)
// ==================================================
function dodajZnak(input, character) {
    // Sprawdza czy znak jest kropką i czy nie została już wprowadzona kropka
    if ((character == '.' && decimal == "0") || character != '.') {
        // Jeśli pole puste lub zawiera "0", zastępuje wartość nowym znakiem
        // W przeciwnym razie dopisuje znak na końcu
        (input.value == "" || input.value == "0") ? input.value = character : input.value += character;
        
        // Przeliczenie jednostek po wprowadzeniu nowego znaku
        convert(input.form, input.form.measure1, input.form.measure2);
        
        // Ustawienie flagi, że wykonano obliczenie
        computed = true;
        
        // Jeśli wprowadzono kropkę, ustaw flagę decimal
        if (character == '.') {
            decimal = 1;
        }
    }
}

// ==================================================
// FUNKCJA OTWIERAJĄCA NOWE OKNO (PUSTE)
// ==================================================
function openVothcom() {
    // Otwiera nowe okno przeglądarki
    window.open("", "Display window", "toolbar=no,directories=no,menubar=no");
}

// ==================================================
// FUNKCJA CZYSZCZENIA POL FORMULARZA
// ==================================================
function wyczysc(form) {
    form.input.value = 0;    // Zeruje pole wejściowe
    form.display.value = 0;  // Zeruje pole wyjściowe
    decimal = 0;              // Resetuje flagę kropki
}

// ==================================================
// FUNKCJA ZMIANY TŁA STRONY
// ==================================================
function zmienTlo(hexNumber) {
    document.bgColor = hexNumber; // Ustawia kolor tła dokumentu
}
