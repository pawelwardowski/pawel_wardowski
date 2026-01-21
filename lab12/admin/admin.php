<?php
/*************************************************
 * PLIK: admin.php
 * OPIS: Panel administracyjny strony
 *       - logowanie administratora
 *       - zarządzanie podstronami (CRUD)
 *************************************************/


/* =============================================
 * Inicjalizacja sesji użytkownika
 * ============================================= */
session_start();


/* =============================================
 * Dołączenie konfiguracji bazy danych
 * (zmienne: $link, $login, $pass)
 * ============================================= */
include("../cfg.php");
include("Kategorie.php");   
include("Produkty.php"); 

$kategorie = new Kategorie($link); // inicjalizacja klasy z połączeniem DB
$produkty = new Produkty($link);



/* =============================================
 * FUNKCJA: Formularz logowania administratora
 * Zwraca formularz HTML do logowania
 * ============================================= */
function FormularzLogowania() {
    return '
    <h2>Panel administracyjny – logowanie</h2>
    <form method="POST">
        <label>Login:</label><br>
        <input type="text" name="login"><br><br>

        <label>Hasło:</label><br>
        <input type="password" name="haslo"><br><br>

        <input type="submit" value="Zaloguj">
    </form>';
}


/* =============================================
 * OBSŁUGA LOGOWANIA
 * ============================================= */

/* Ustawienie domyślnej wartości sesji */
if (!isset($_SESSION['logged'])) {
    $_SESSION['logged'] = false;
}

/* Jeśli użytkownik nie jest zalogowany */
if ($_SESSION['logged'] === false) {

    /* Sprawdzenie danych przesłanych z formularza */
    if (isset($_POST['login']) && isset($_POST['haslo'])) {

        /* Porównanie z danymi z cfg.php */
        if ($_POST['login'] == $login && $_POST['haslo'] == $pass) {

            /* Poprawne logowanie */
            $_SESSION['logged'] = true;
            header("Location: admin.php");
            exit;

        } else {

            /* Błędne dane logowania */
            echo "<p style='color:red;'>Błędny login lub hasło!</p>";
            echo FormularzLogowania();
            exit;
        }
    }

    /* Wyświetlenie formularza logowania */
    echo FormularzLogowania();
    exit;
}


/* =============================================
 * WYLOGOWANIE
 * ============================================= */
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}


/* =============================================
 * MENU PANELU ADMINISTRACYJNEGO
 * ============================================= */
echo '<h1>Panel administracyjny</h1>';
echo '
<a href="admin.php?task=list">Lista podstron</a> |
<a href="admin.php?task=add">Dodaj podstronę</a> |
<a href="admin.php?task=list_categories">Lista kategorii</a> |
<a href="admin.php?task=add_category">Dodaj kategorię</a> |

<a href="admin.php?task=list_products">Lista produktów</a> |
<a href="admin.php?task=add_product">Dodaj produkt</a> |
<a href="admin.php?logout=1">Wyloguj</a>
<hr>
';


/* =============================================
 * FUNKCJA: ListaPodstron
 * Wyświetla listę podstron z bazy danych
 * ============================================= */
function ListaPodstron($link) {

    /* Zapytanie SQL pobierające wszystkie podstrony */
    $sql = "SELECT * FROM page_list ORDER BY id ASC";
    $result = mysqli_query($link, $sql);

    echo "<h2>Lista podstron</h2>";

    echo "<table border='1' cellpadding='6'>
            <tr>
                <th>ID</th>
                <th>Tytuł</th>
                <th>Status</th>
                <th>Akcje</th>
            </tr>";

    /* Iteracja po wynikach zapytania */
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['page_title']}</td>
            <td>".($row['status'] ? "Aktywna" : "Nieaktywna")."</td>
            <td>
                <a href='admin.php?task=edit&id={$row['id']}'>Edytuj</a> |
                <a href='admin.php?task=delete&id={$row['id']}' onclick=\"return confirm('Usunąć podstronę?');\">Usuń</a>
            </td>
        </tr>";
    }

    echo "</table>";
}


/* =============================================
 * FUNKCJA: DodajNowaPodstrone
 * Dodaje nową podstronę do bazy danych
 * ============================================= */
function DodajNowaPodstrone($link) {

    /* Obsługa formularza POST */
    if (isset($_POST['title']) && isset($_POST['content'])) {

        /* Zabezpieczenie danych przed SQL Injection */
        $title   = mysqli_real_escape_string($link, $_POST['title']);
        $content = mysqli_real_escape_string($link, $_POST['content']);
        $active  = isset($_POST['active']) ? 1 : 0;

        /* Zapytanie INSERT */
        $sql = "INSERT INTO page_list (page_title, page_content, status)
                VALUES ('$title', '$content', '$active')";

        mysqli_query($link, $sql);

        echo "<p><b>Dodano podstronę</b></p>";
    }

    /* Formularz dodawania podstrony */
    echo '
    <h2>Dodaj nową podstronę</h2>
    <form method="POST">
        Tytuł:<br>
        <input type="text" name="title"><br><br>

        Treść:<br>
        <textarea name="content" rows="10" cols="60"></textarea><br><br>

        Aktywna:
        <input type="checkbox" name="active"><br><br>

        <input type="submit" value="Dodaj">
    </form>';
}


/* =============================================
 * FUNKCJA: EdytujPodstrone
 * Edycja istniejącej podstrony
 * ============================================= */
function EdytujPodstrone($link, $id) {

    $id = (int)$id; // zabezpieczenie ID

    /* Zapis zmian */
    if (isset($_POST['title'])) {

        $title   = mysqli_real_escape_string($link, $_POST['title']);
        $content = mysqli_real_escape_string($link, $_POST['content']);
        $active  = isset($_POST['active']) ? 1 : 0;

        $sql = "UPDATE page_list 
                SET page_title='$title', page_content='$content', status='$active'
                WHERE id=$id LIMIT 1";

        mysqli_query($link, $sql);

        echo "<p><b>Zapisano zmiany!</b></p>";
    }

    /* Pobranie danych do formularza */
    $sql = "SELECT * FROM page_list WHERE id=$id LIMIT 1";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    echo '
    <h2>Edytuj podstronę</h2>
    <form method="POST">
        Tytuł:<br>
        <input type="text" name="title" value="'.$row['page_title'].'"><br><br>

        Treść:<br>
        <textarea name="content" rows="10" cols="60">'.$row['page_content'].'</textarea><br><br>

        Aktywna:
        <input type="checkbox" name="active" '.($row['status'] ? "checked" : "").'><br><br>

        <input type="submit" value="Zapisz zmiany">
    </form>';
}


/* =============================================
 * FUNKCJA: UsunPodstrone
 * Usuwa podstronę z bazy danych
 * ============================================= */
function UsunPodstrone($link, $id) {

    $id = (int)$id; // zabezpieczenie ID

    $sql = "DELETE FROM page_list WHERE id=$id LIMIT 1";
    mysqli_query($link, $sql);

    echo "<p><b>Usunięto podstronę</b></p>";
}


/* =============================================
 * OBSŁUGA PARAMETRU GET ?task=
 * Wywołuje odpowiednie funkcje
 * ============================================= */
if (isset($_GET['task'])) {

    switch ($_GET['task']) {

        case "list":
            ListaPodstron($link);
            break;

        case "add":
            DodajNowaPodstrone($link);
            break;

        case "edit":
            if (isset($_GET['id'])) {
                EdytujPodstrone($link, $_GET['id']);
            }
            break;

        case "delete":
            if (isset($_GET['id'])) {
                UsunPodstrone($link, $_GET['id']);
            }
            break;
			
		// Kategorie
        case "list_categories":
            $kategorie->PokazKategorie();
            break;

        case "add_category":
            if(isset($_POST['nazwa'])) {
                $matka = $_POST['matka'] ?? 0;
                $kategorie->DodajKategorie($_POST['nazwa'], $matka);
            }
            echo '<h2>Dodaj kategorię</h2>
                  <form method="POST">
                  Nazwa: <input type="text" name="nazwa"><br>
                  Matka (ID): <input type="number" name="matka" value="0"><br>
                  <input type="submit" value="Dodaj kategorię">
                  </form>';
            break;

        case "edit_category":
            if(isset($_POST['nazwa']) && isset($_GET['id'])) {
                $matka = $_POST['matka'] ?? 0;
                $kategorie->EdytujKategorie($_GET['id'], $_POST['nazwa'], $matka);
            }
            if(isset($_GET['id'])) {
                $id = (int)$_GET['id'];
                echo '<h2>Edytuj kategorię</h2>
                      <form method="POST">
                      Nazwa: <input type="text" name="nazwa"><br>
                      Matka (ID): <input type="number" name="matka" value="0"><br>
                      <input type="submit" value="Zapisz zmiany">
                      </form>';
            }
            break;

        case "delete_category":
            if(isset($_GET['id'])) $kategorie->UsunKategorie((int)$_GET['id']);
            break;
			
		case "list_products":
			$produkty->PokazProdukty();
			break;

		case "add_product":
			if(isset($_POST['title'])) $produkty->DodajProdukt($_POST);
			include("forms/add_product_form.php");
			break;

		case "edit_product":
			if(isset($_POST['title']) && isset($_GET['id'])) $produkty->EdytujProdukt($_GET['id'], $_POST);

			if(isset($_GET['id'])) {
			$id = (int)$_GET['id'];
			$sql = "SELECT * FROM products WHERE id=$id LIMIT 1";
			$result = mysqli_query($link, $sql);
			$product = mysqli_fetch_assoc($result);
			include("forms/edit_product_form.php");
			}
			break;

		case "delete_product":
			if(isset($_GET['id'])) $produkty->UsunProdukt($_GET['id']);
			break;

    }
}
?>
