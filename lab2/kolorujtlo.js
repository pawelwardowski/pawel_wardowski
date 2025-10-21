var computed = false;
var decimal = 0;

function przeliczJednostki (entryform, form, to)
{
	convertfrom = from.selectedIndex;
	convertto = to.selectedIndex;
	entryform.display.value = (entryform.input.value * from[convertfrom].value / to[convertto].value);
}

function dodajZnak (input, character)
{
		if((character=='.' && decimal=="0") || character!='.')
		{
			(input.value == "" || input.value == "0") ? input.value = character : input.value += character 
			convert(input.form,input.form.measure1,input.form.measure2)
			computed = true;
			if (character=='.')
			{
				decimal = 1;
			}
		}
}

function openVothcom()
{
	window.open("","Display window","toolbar=no,directories=no,menubar=no");
}

function wyczysc (form)
{
	form.input.value = 0;
	form.display.value = 0;
	decimal=0;
}

function zmienTlo(hexNumber)
{
	document.bgColor = hexNumber;
}

function przejdzDoKolejnejStrony() {
	const strony = [
		"index.html",
		"burj_khalifa.html",
		"merdeka.html",
		"shanghai_tower.html",
		"lotte_world.html",
		"kontakt.html"
	];

	let obecnaStrona = window.location.pathname.split("/").pop();
	let indeks = strony.indexOf(obecnaStrona);
	let nastepnaStrona = strony[(indeks + 1) % strony.length];
	window.location.href = nastepnaStrona;
}

function przejdzDoPoprzedniejStrony() {
	const strony = [
		"index.html",
		"burj_khalifa.html",
		"merdeka.html",
		"shanghai_tower.html",
		"lotte_world.html",
		"kontakt.html"
	];

	let obecnaStrona = window.location.pathname.split("/").pop();
	let indeks = strony.indexOf(obecnaStrona);

	let poprzedniaStrona = strony[(indeks - 1 + strony.length) % strony.length];
	window.location.href = poprzedniaStrona;
}