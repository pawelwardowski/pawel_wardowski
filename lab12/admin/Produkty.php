<?php
/*************************************************
 * KLASA: Produkty
 * OPIS: System zarządzania produktami sklepu
 *************************************************/
class Produkty {
    private $link; // połączenie do DB

    public function __construct($link) {
        $this->link = $link;
    }

    /* =============================================
     * Pokazuje wszystkie produkty wraz z warunkami dostępności
     * ============================================= */
    public function PokazProdukty() {
        $sql = "SELECT * FROM products ORDER BY id ASC";
        $result = mysqli_query($this->link, $sql);

        echo "<h2>Lista produktów</h2>";
        echo "<table border='1' cellpadding='6'>
                <tr>
                    <th>ID</th>
                    <th>Tytuł</th>
                    <th>Cena netto</th>
                    <th>VAT</th>
                    <th>Ilość</th>
                    <th>Status</th>
                    <th>Kategoria</th>
                    <th>Obraz</th>
                    <th>Akcje</th>
                </tr>";

        while ($row = mysqli_fetch_assoc($result)) {

            // warunki dostępności
            $available = ($row['status']=='available' && $row['quantity']>0 && (empty($row['expires_at']) || strtotime($row['expires_at']) > time())) ? "Dostępny" : "Niedostępny";

            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['title']}</td>
                    <td>{$row['price_net']} zł</td>
                    <td>{$row['vat']}%</td>
                    <td>{$row['quantity']}</td>
                    <td>$available</td>
                    <td>{$row['category_id']}</td>
                    <td><img src='{$row['image']}' width='50'></td>
                    <td>
                        <a href='admin.php?task=edit_product&id={$row['id']}'>Edytuj</a> |
                        <a href='admin.php?task=delete_product&id={$row['id']}' onclick=\"return confirm('Usunąć produkt?');\">Usuń</a>
                    </td>
                  </tr>";
        }

        echo "</table>";
    }

    /* =============================================
     * Dodaje nowy produkt
     * ============================================= */
    public function DodajProdukt($data) {
        $title       = mysqli_real_escape_string($this->link, $data['title']);
        $description = mysqli_real_escape_string($this->link, $data['description']);
        $price_net   = (float)$data['price_net'];
        $vat         = (float)$data['vat'];
        $quantity    = (int)$data['quantity'];
        $status      = ($data['status']=='available') ? 'available' : 'unavailable';
        $category_id = (int)$data['category_id'];
        $size        = mysqli_real_escape_string($this->link, $data['size']);
        $image       = mysqli_real_escape_string($this->link, $data['image']);
        $expires_at  = !empty($data['expires_at']) ? "'".$data['expires_at']."'" : "NULL";

        $sql = "INSERT INTO products 
                (title, description, price_net, vat, quantity, status, category_id, size, image, expires_at) 
                VALUES ('$title','$description',$price_net,$vat,$quantity,'$status',$category_id,'$size','$image',$expires_at)";
        mysqli_query($this->link, $sql);
        echo "<p><b>Produkt dodany!</b></p>";
    }

    /* =============================================
     * Edycja istniejącego produktu
     * ============================================= */
    public function EdytujProdukt($id, $data) {
        $id = (int)$id;
        $title       = mysqli_real_escape_string($this->link, $data['title']);
        $description = mysqli_real_escape_string($this->link, $data['description']);
        $price_net   = (float)$data['price_net'];
        $vat         = (float)$data['vat'];
        $quantity    = (int)$data['quantity'];
        $status      = ($data['status']=='available') ? 'available' : 'unavailable';
        $category_id = (int)$data['category_id'];
        $size        = mysqli_real_escape_string($this->link, $data['size']);
        $image       = mysqli_real_escape_string($this->link, $data['image']);
        $expires_at  = !empty($data['expires_at']) ? "'".$data['expires_at']."'" : "NULL";

        $sql = "UPDATE products SET 
                    title='$title', 
                    description='$description', 
                    price_net=$price_net, 
                    vat=$vat, 
                    quantity=$quantity, 
                    status='$status', 
                    category_id=$category_id, 
                    size='$size', 
                    image='$image', 
                    expires_at=$expires_at 
                WHERE id=$id LIMIT 1";
        mysqli_query($this->link, $sql);
        echo "<p><b>Produkt zaktualizowany!</b></p>";
    }

    /* =============================================
     * Usuwa produkt
     * ============================================= */
    public function UsunProdukt($id) {
        $id = (int)$id;
        $sql = "DELETE FROM products WHERE id=$id LIMIT 1";
        mysqli_query($this->link, $sql);
        echo "<p><b>Produkt usunięty!</b></p>";
    }
}
?>
