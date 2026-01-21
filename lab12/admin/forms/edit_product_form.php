<h2>Edytuj produkt</h2>
<form method="POST">
    Tytuł:<br>
    <input type="text" name="title" value="<?php echo htmlspecialchars($product['title']); ?>" required><br><br>

    Opis:<br>
    <textarea name="description" rows="6" cols="60" required><?php echo htmlspecialchars($product['description']); ?></textarea><br><br>

    Cena netto:<br>
    <input type="number" step="0.01" name="price_net" value="<?php echo $product['price_net']; ?>" required><br><br>

    VAT (%):<br>
    <input type="number" step="0.01" name="vat" value="<?php echo $product['vat']; ?>" required><br><br>

    Ilość w magazynie:<br>
    <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>" required><br><br>

    Status:<br>
    <select name="status">
        <option value="available" <?php if($product['status']=='available') echo 'selected'; ?>>Dostępny</option>
        <option value="unavailable" <?php if($product['status']=='unavailable') echo 'selected'; ?>>Niedostępny</option>
    </select><br><br>

    Kategoria (ID):<br>
    <input type="number" name="category_id" value="<?php echo $product['category_id']; ?>"><br><br>

    Gabaryt:<br>
    <input type="text" name="size" value="<?php echo htmlspecialchars($product['size']); ?>"><br><br>

    Link do zdjęcia:<br>
    <input type="text" name="image" value="<?php echo htmlspecialchars($product['image']); ?>"><br><br>

    Data wygaśnięcia (YYYY-MM-DD HH:MM:SS):<br>
    <input type="text" name="expires_at" value="<?php echo $product['expires_at']; ?>"><br><br>

    <input type="submit" value="Zapisz zmiany">
</form>
