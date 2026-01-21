<?php
/****************************************
 * PLIK: showpage.php
 * OPIS: Obsługa wyświetlania treści
 *       podstron z bazy danych
 ****************************************/
 
 
 /**
 * Funkcja pobiera treść podstrony z bazy danych
 * na podstawie jej identyfikatora.
 *
 * @param mysqli $link - połączenie z bazą danych
 * @param int $id - ID podstrony
 * @return string - treść strony lub komunikat błędu
 */
 
function PokazPodstrone($idp)
{
    global $link;

    $idp = mysqli_real_escape_string($link, $idp);

    $sql = "SELECT page_content FROM page_list WHERE page_title = '$idp' AND status = 1 LIMIT 1";
    $result = mysqli_query($link, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        return $row['page_content'];
    }

    return "<p>Strona nie istnieje</p>";
}

?>