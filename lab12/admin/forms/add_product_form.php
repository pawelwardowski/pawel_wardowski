<h2>Dodaj nowy produkt</h2>
<form method="POST">
    Tytuł:<br>
    <input type="text" name="title" required><br><br>

    Opis:<br>
    <textarea name="description" rows="6" cols="60" required></textarea><br><br>

    Cena netto:<br>
    <input type="number" step="0.01" name="price_net" required><br><br>

    VAT (%):<br>
    <input type="number" step="0.01" name="vat" required><br><br>

    Ilość w magazynie:<br>
    <input type="number" name="quantity" required><br><br>

    Status:<br>
    <select name="status">
        <option value="available">Dostępny</option>
        <option value="unavailable">Niedostępny</option>
    </select><br><br>

    Kategoria (ID):<br>
    <input type="number" name="category_id" value="0"><br><br>

    Gabaryt:<br>
    <input type="text" name="size"><br><br>

    Link do zdjęcia:<br>
    <input type="text" name="image"><br><br>

    Data wygaśnięcia (YYYY-MM-DD HH:MM:SS):<br>
    <input type="text" name="expires_at"><br><br>

    <input type="submit" value="Dodaj produkt">
</form>
