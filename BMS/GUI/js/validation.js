var name = document.getElementById('name');
var lastname = document.getElementById('lastname');
var email = document.getElementById('email');
var password = document.getElementById('password');
var birth = document.getElementById('birth');
var pics = document.getElementById('pics');
var telefon = document.getElementById('telefon');
var plata = document.getElementById('plata');
var radno = document.getElementById('radno');
var rola = document.getElementById('rola');
var opis = document.getElementById('opis');
var btn = document.getElementById('btn');
var err = document.getElementsByClassName('error');

function loginValidation () {
	let xx = 1;
	err[0].innerHTML = "";
	err[1].innerHTML = "";
	if (email.value == "") {
		err[0].innerHTML = 'Morate uneti mail';
		xx = 0;
	}  else if(email.value.indexOf('gmail') == -1) {
		err[0].innerHTML = 'Vas mail mora biti gmail!';
		xx = 0;
	} 
	if(password.value == "") {
		err[1].innerHTML = 'Morate uneti password';
		xx = 0;
	}

	if (xx == 1) {
		return true;
	} else {
		return false;
	}
}
function profileValidation() {
let xx = 1;

// for (var i = err.length - 1; i >= 0; i--) {
// 	err[i].innerHTML = "";
// }
for (var i = 0; i < err.length; i++){
	err[i].innerHTML = "";
}

	if (name.value == "") {
		err[0].innerHTML = "Morate uneti ime";
		xx = 0;
	}
	if (lastname.value == "") {
		err[1].innerHTML = "Morate uneti prezime";
		xx = 0;
	}
	if (email.value == "") {
		err[2].innerHTML = 'Morate uneti mail';
		xx = 0;
	}  else if(email.value.indexOf('gmail') == -1) {
		err[2].innerHTML = 'Vas mail mora biti gmail!';
		xx = 0;
	} 
	if(password.value == "") {
		err[3].innerHTML = 'Morate uneti password';
		xx = 0;
	}
	if (birth.value == "") {
		err[4].innerHTML = "Morate uneti datum rodjenja";
		xx = 0;
	}	
	if (pics.value == "") {
		err[5].innerHTML = "Morate uneti sliku";
		xx = 0;
	}
	if (telefon.value == "") {
		err[6].innerHTML = "Morate uneti telefon";
		xx = 0;
	}	
	if (plata.value == "") {
		err[7].innerHTML = "Morate uneti platu";
		xx = 0;
	}
	if (radno.value == "") {
		err[8].innerHTML = "Morate izabrati radno mesto";
		xx = 0;
	}	
	if (rola.value == "") {
		err[9].innerHTML = "Morate uneti rolu korisnika";
		xx = 0;
	}

	if (xx == 1) {
		return true;
	} else {
		return false;
	}
}

function workValidation () {
	let xx = 1;
	err[0].innerHTML = "";
	err[1].innerHTML = "";
	if (radno.value == "") {
		err[0].innerHTML = 'Morate uneti naziv radnog Mesta';
		xx = 0;
	}  
	if(opis.value == "") {
		err[1].innerHTML = 'Morate uneti opis';
		xx = 0;
	}

	if (xx == 1) {
		return true;
	} else {
		return false;
	}
}