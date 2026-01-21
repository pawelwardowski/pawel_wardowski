<?php
/****************************************
 * PLIK: cfg.php
 * OPIS: Plik konfiguracyjny aplikacji
 *       - dane bazy danych
 *       - dane logowania administratora
 *       - połączenie z bazą MySQL
 * AUTOR: Paweł Wardowski
 * WERSJA: v1.8
 ****************************************/
 
 
 /* ------------------------------------
   DANE KONFIGURACYJNE BAZY DANYCH
------------------------------------ */
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';
	$baza = 'moja_strona';
	$login = 'admin';
	$pass = '123';
	
	
/* ------------------------------------
	POŁĄCZENIE Z BAZĄ DANYCH
------------------------------------ */

	$link = mysqli_connect($dbhost,$dbuser,$dbpass,$baza);

	
	/*Sprawdzanie poprawności połączenia*/
	if (!$link) 
	{
		die('<b>Przerwane połączenie z bazą!</b>');
	}
	mysqli_set_charset($link, "utf8");


	
?>