<?php

/*************************************************
 * FUNKCJA: addToCart
 * OPIS:
 * Dodaje produkt do koszyka zapisanego w $_SESSION.
 * Jeśli produkt już istnieje w koszyku – zwiększa
 * ilość sztuk.
 *
 * PARAMETRY:
 * $id  - ID produktu z bazy danych
 * $qty - ilość dodawanych sztuk
 *************************************************/
function addToCart($id, $qty)
{
    // Jeżeli koszyk nie istnieje – inicjalizacja
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Jeśli produkt jest już w koszyku – zwiększ ilość
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] += $qty;
    }
    // Jeśli produkt nie istnieje – dodaj nowy wpis
    else {
        $_SESSION['cart'][$id] = $qty;
    }
}


/*************************************************
 * FUNKCJA: showCart
 * OPIS:
 * Wyświetla zawartość koszyka wraz z:
 * - nazwą produktu
 * - ilością sztuk
 * - ceną brutto
 * - sumą całkowitą koszyka
 *
 * PARAMETRY:
 * $link - połączenie z bazą danych MySQL
 *************************************************/
function showCart($link)
{
    // Sprawdzenie czy koszyk jest pusty
    if (empty($_SESSION['cart'])) {
        echo "<p>Koszyk pusty</p>";
        return;
    }

    echo "<h2>Koszyk</h2>";

    // Zmienna przechowująca sumę całkowitą
    $sum = 0;

    // Iteracja po produktach zapisanych w sesji
    foreach ($_SESSION['cart'] as $id => $qty) {

        // Zabezpieczenie ID produktu
        $id = (int)$id;

        // Pobranie danych produktu z bazy danych
        $sql = "SELECT * FROM products WHERE id=$id LIMIT 1";
        $p = mysqli_fetch_assoc(mysqli_query($link, $sql));

        // Obliczenie ceny brutto (netto + VAT)
        $brutto = $p['price_net'] * (1 + $p['vat'] / 100);

        // Wartość pozycji (cena * ilość)
        $line = $brutto * $qty;

        // Dodanie do sumy końcowej
        $sum += $line;

        // Wyświetlenie produktu w koszyku
        echo "
        <p>
            {$p['title']} – {$qty} szt. – 
            ".number_format($line, 2)." zł
            <a href='?remove=$id'>❌</a>
        </p>";
    }

    // Wyświetlenie sumy koszyka
    echo "<h3>Razem: ".number_format($sum, 2)." zł</h3>";
}

?>
