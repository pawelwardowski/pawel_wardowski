<?php
session_start();
// Dołączenie pliku konfiguracyjnego (baza danych, zmienne globalne)
	include('cfg.php');
	include ('functions/products.php');
	include ('functions/cart.php');
	include ('functions/categories.php');
	include('showpage.php');

	
if (isset($_POST['add_to_cart'])) {
    addToCart((int)$_POST['add_to_cart'], (int)$_POST['qty']);
}

if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
}


?>

<?php
/****************************************
 * PLIK: index.php
 * OPIS: Główny szablon strony.
 *       Dynamiczne ładowanie podstron
 *       przy użyciu $_GET oraz include()
 * AUTOR: Paweł Wardowski
 * WERSJA: v1.8
 ****************************************/
 
 // Włączenie raportowania błędów
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);


?>



<!-- ====================================
     SZABLON STRONY – CZĘŚĆ HTML
     Zawiera:
     - nagłówek strony (head)
     - menu nawigacyjne
     - miejsce na treść dynamiczną
==================================== -->
<!DOCTYPE html>
<html lang="pl">
<head>
<!-- ====================================
       SEKCJA HEAD
       Metadane strony, style CSS oraz
       biblioteki JavaScript
  ==================================== -->

<meta charset="UTF-8">
<meta name="description" content="Największe budynki świata">
<title>Największe budynki świata</title>


  <!-- Biblioteka jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Arkusz stylów strony -->
<link rel="stylesheet" href="css/style.css">
  <!-- Skrypty JavaScript -->
<script src="js/kolorujtlo.js"></script>
<script src="js/timedate.js"></script>

</head>
<!-- ====================================
     BODY STRONY
     Wywołanie zegara po załadowaniu strony
==================================== -->

<body onload="startclock()">

<!-- ====================================
     GŁÓWNA STRUKTURA STRONY
     Zrealizowana przy pomocy tabeli
==================================== -->
<table>
  <tr>
    <!-- ====================================
       MENU NAWIGACYJNE
       Linki wykorzystują parametr $_GET
       do dynamicznego ładowania podstron
     ==================================== -->
<td colspan="2" class="menu">
      <a href="index.php">Strona główna</a>
      <a href="index.php?idp=burj_khalifa">Burj Khalifa</a>
      <a href="index.php?idp=merdeka">Merdeka 118</a>
      <a href="index.php?idp=shanghai_tower">Shanghai Tower</a>
      <a href="index.php?idp=lotte_world">Lotte World Tower</a>
	  <a href="index.php?idp=filmy">Filmy</a>
      <a href="index.php?idp=kontakt">Kontakt</a>
	  <a href="index.php?idp=produkty">Produkty</a>
	  <a href="index.php?idp=koszyk">Koszyk</a>
	  
     <!-- Zegar i aktualna data -->
      <div class="czas">
        <div id="zegarek"></div>
        <div id="data"></div>
      </div>
    </td>
  </tr>
  <!-- ====================================
       SEKCJA TREŚCI STRONY
       Dynamiczne ładowanie podstron
  ==================================== -->
  <tr>
    <td colspan="2" class="content">

	
      <?php 
		/* ------------------------------------
		OBSŁUGA PARAMETRU $_GET['idp']
		Na jego podstawie wybierana jest
		podstrona do załadowania przez include()
		------------------------------------ */
		$idp = $_GET['idp'] ?? 'glowna';
		switch ($idp) {

		case 'produkty':
		PokazProdukty($link);
        
        break;
		
		case 'koszyk':
		showCart($link);
		break;

		default:
        echo PokazPodstrone($idp);
        break;
		}
		?>

    </td>
  </tr>
</table>

<?php
//informacje o autorze
$nr_indeksu = '164457';
$nrGrupy = '2';
$ver = 'v1.8';
echo 'Autor: Paweł Wardowski '.$nr_indeksu.' grupa '.$nrGrupy.' wersja '.$ver.' <br><br>';
?>

<script>
/* ------------------------------------
   Efekt powiększania obrazów
   po najechaniu kursorem
------------------------------------ */
$(document).ready(function() {
  $(".zoom-image").on({
    mouseover: function() {
      $(this).stop().animate({
        width: "+=50px"
      }, 400);
    },
    mouseout: function() {
      $(this).stop().animate({
        width: "-=50px"
      }, 400);
    }
  });
});
</script>

<script>
//funckje obsługujące nawigację pomiędzy stronami
function przejdzDoKolejnejStrony() {
    const strony = [
        "glowna",
        "burj_khalifa",
        "merdeka",
        "shanghai_tower",
        "lotte_world",
        "kontakt"
    ];

    let params = new URLSearchParams(window.location.search);
    let obecna = params.get("idp") || "glowna";

    let index = strony.indexOf(obecna);
    let next = strony[(index + 1) % strony.length];

    window.location.href = "index.php?idp=" + next;
}

function przejdzDoPoprzedniejStrony() {
    const strony = [
        "glowna",
        "burj_khalifa",
        "merdeka",
        "shanghai_tower",
        "lotte_world",
        "kontakt"
    ];

    let params = new URLSearchParams(window.location.search);
    let obecna = params.get("idp") || "glowna";

    let index = strony.indexOf(obecna);
    let prev = strony[(index - 1 + strony.length) % strony.length];

    window.location.href = "index.php?idp=" + prev;
}

</script>

</body>
</html>
