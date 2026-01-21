<?php
class Kategorie {
    private $link; // połączenie z bazą

    public function __construct($link) {
        $this->link = $link;
    }

    // --------------------------
    // Dodaj kategorię
    // --------------------------
    public function DodajKategorie($nazwa, $matka = 0) {
        $nazwa = mysqli_real_escape_string($this->link, $nazwa);
        $matka = (int)$matka;

        $sql = "INSERT INTO categories (nazwa, matka) VALUES ('$nazwa', $matka)";
        mysqli_query($this->link, $sql);
        echo "<p>Kategoria dodana!</p>";
    }

    // --------------------------
    // Usuń kategorię
    // --------------------------
    public function UsunKategorie($id) {
        $id = (int)$id;
        $sql = "DELETE FROM categories WHERE id=$id LIMIT 1";
        mysqli_query($this->link, $sql);
        echo "<p>Kategoria usunięta!</p>";
    }

    // --------------------------
    // Edytuj kategorię
    // --------------------------
    public function EdytujKategorie($id, $nazwa, $matka = 0) {
        $id = (int)$id;
        $nazwa = mysqli_real_escape_string($this->link, $nazwa);
        $matka = (int)$matka;

        $sql = "UPDATE categories SET nazwa='$nazwa', matka=$matka WHERE id=$id LIMIT 1";
        mysqli_query($this->link, $sql);
        echo "<p>Kategoria zaktualizowana!</p>";
    }

    // --------------------------
    // Wyświetl wszystkie kategorie w formie drzewa
    // --------------------------
    public function PokazKategorie() {
        // 1. Pobierz wszystkie kategorie główne (matka = 0)
        $sql = "SELECT * FROM categories WHERE matka=0 ORDER BY id ASC";
        $result = mysqli_query($this->link, $sql);

        echo "<ul>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<li><b>".$row['nazwa']."</b>";

            // 2. Pętla zagnieżdżona - pobierz podkategorie
            $matkaId = (int)$row['id'];
            $sql2 = "SELECT * FROM categories WHERE matka=$matkaId ORDER BY id ASC";
            $result2 = mysqli_query($this->link, $sql2);

            if(mysqli_num_rows($result2) > 0) {
                echo "<ul>";
                while($sub = mysqli_fetch_assoc($result2)) {
                    echo "<li>".$sub['nazwa']."</li>";
                }
                echo "</ul>";
            }

            echo "</li>";
        }
        echo "</ul>";
    }
}
?>
