<?php

function PokazProdukty($link)
{
    // Budujemy zapytanie
    $sql = "SELECT * FROM products WHERE status = 1";

    //  Jeśli wybrano kategorię
    if (isset($_GET['category_id'])) {
        $kat = (int)$_GET['category_id'];
        $sql .= " AND category_id = $kat";
    }

    // Wykonanie zapytania
    $result = mysqli_query($link, $sql);

    echo "<h2>Produkty</h2>";

    // Wyświetlanie produktów
    while ($p = mysqli_fetch_assoc($result)) {

        // dostępność
        if ($p['quantity'] <= 0) {
            echo "<p><b>{$p['title']}</b> – brak w magazynie</p>";
            continue;
        }

        // cena brutto
        $brutto = $p['price_net'] * (1 + $p['vat'] / 100);

        echo "
        <div class='product'>
            <h3>{$p['title']}</h3>
            <p>Cena brutto: ".number_format($brutto, 2)." zł</p>

            <form method='POST'>
                <input type='number' name='qty' value='1' min='1'>
                <button type='submit' name='add_to_cart' value='{$p['id']}'>
                    Dodaj do koszyka
                </button>
            </form>
        </div>
        <hr>";
    }
}
