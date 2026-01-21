<?php
/*************************************************
 * PLIK: contact.php
 * OPIS: Obsługa formularza kontaktowego
 *       oraz przypomnienia hasła administratora
 *************************************************/


/* =============================================
 * FUNKCJA: PokazKontakt
 * Wyświetla formularz kontaktowy HTML
 * Formularz jest kompatybilny z metodą
 * WyslijMailKontakt()
 * ============================================= */
function PokazKontakt()
{
    return '
        <h2>Formularz kontaktowy</h2>
        <form method="POST" action="contact.php?task=sendmail">
            
            <label>Twój email:</label><br>
            <input type="email" name="email" required><br><br>

            <label>Temat wiadomości:</label><br>
            <input type="text" name="temat" required><br><br>

            <label>Treść wiadomości:</label><br>
            <textarea name="tresc" rows="6" required></textarea><br><br>

            <input type="submit" value="Wyślij wiadomość">
        </form>
    ';
}


/* =============================================
 * FUNKCJA: WyslijMailKontakt
 * Wysyła wiadomość email do administratora
 * Sprawdza poprawność danych z formularza
 * i ponownie wyświetla formularz w razie błędu
 * ============================================= */
function WyslijMailKontakt($odbiorca)
{
    /* Walidacja danych przesłanych metodą POST */
    if (empty($_POST['email']) || empty($_POST['temat']) || empty($_POST['tresc'])) {
        echo "[niewypelnione_pole]<br>";
        echo PokazKontakt();   // ponowne wyświetlenie formularza
        return;
    }

    /* Przypisanie danych z formularza */
    $mail['subject']   = $_POST['temat'];
    $mail['body']      = $_POST['tresc'];
    $mail['sender']    = $_POST['email'];
    $mail['recipient'] = $odbiorca;

    /* Nagłówki wiadomości */
    $header  = "From: Formularz kontaktowy <".$mail['sender'].">\n";
    $header .= "MIME-Version: 1.0\n";
    $header .= "Content-Type: text/plain; charset=utf-8\n";
    $header .= "X-Mailer: PHP/" . phpversion() . "\n";

    /* Wysłanie wiadomości */
    mail($mail['recipient'], $mail['subject'], $mail['body'], $header);

    echo "[wiadomosc_wyslana]";
}


/* =============================================
 * FUNKCJA: PrzypomnijHaslo
 * Wysyła hasło administratora na wskazany email
 * UWAGA: metoda uproszczona – niebezpieczna
 * ============================================= */
function PrzypomnijHaslo($emailDocelowy, $hasloAdmina)
{
    /* Sprawdzenie czy email został podany */
    if (empty($_POST['email'])) {
        echo "[niewypelnione_pole]<br>";
        echo FormularzPrzypomnieniaHasla();
        return;
    }

    /* Dane wiadomości */
    $nadawca = $_POST['email'];
    $subject = "Przypomnienie hasła do panelu admina";
    $body    = "Hasło administratora to: " . $hasloAdmina;

    /* Nagłówki wiadomości */
    $header  = "From: Panel admina <".$nadawca.">\n";
    $header .= "MIME-Version: 1.0\n";
    $header .= "Content-Type: text/plain; charset=utf-8\n";

    /* Wysłanie maila z hasłem */
    mail($emailDocelowy, $subject, $body, $header);

    echo "[haslo_wyslane]";
}


/* =============================================
 * FUNKCJA: FormularzPrzypomnieniaHasla
 * Formularz HTML do przypomnienia hasła
 * ============================================= */
function FormularzPrzypomnieniaHasla()
{
    return '
        <h2>Przypomnienie hasła</h2>
        <form method="POST" action="contact.php?task=przypomnij">
            
            <label>Podaj swój email:</label><br>
            <input type="email" name="email" required><br><br>

            <input type="submit" value="Wyślij przypomnienie">
        </form>
    ';
}


/* =============================================
 * DANE ADMINISTRATORA (UPROSZCZONE)
 * ============================================= */
$adminEmail = "admin@domena.pl";
$adminPass  = "123";


/* =============================================
 * OBSŁUGA PARAMETRU GET ?task=
 * Sterowanie działaniem pliku contact.php
 * ============================================= */
if (isset($_GET['task'])) {

    switch ($_GET['task']) {

        case "sendmail":
            WyslijMailKontakt($adminEmail);
            break;

        case "przypomnij":
            PrzypomnijHaslo($adminEmail, $adminPass);
            break;
    }

} else {
    /* Domyślnie wyświetlane formularze */
    echo PokazKontakt();
    echo "<hr><br>";
    echo FormularzPrzypomnieniaHasla();
}
?>
