function setCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
	var expires = "expires=" + d.toGMTString();
	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
	var name = cname + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(";");
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == " ") {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}

function checkCookie() {
	var nom = getCookie("user-nom");
	var prenom = getCookie("user-prenom");
	var telephone = getCookie("user-telephone");
	var email = getCookie("user-email");

    // console.log("==============================");
    // console.log("On vérifie si les variables de cookies sont définies dans la fonction checkCookie()");
	// console.log("Nom :", nom);
	// console.log("Prénom :", prenom);
	// console.log("Téléphone :", telephone);
	// console.log("E-mail :", email);
    
	if (nom != "" && prenom != "" && telephone != "" && email != "") {
		$("#connected").toast("show");
		$("#js-message-connected").html(
			"Vous êtes connecté en tant que " + nom + " " + prenom + ""
		);
	} else {
		$("#connected").toast("show");
		$("#js-message-connected").html("Vous n'êtes pas connecté.");
		$("#connexionModal").modal("show");

		$("#js-connect").on("click", function () {
			nom = $("#nom").val();
			prenom = $("#prenom").val();
			telephone = $("#telephone").val();
			email = $("#email").val();
			if (
				nom != "" &&
				nom != null &&
				prenom != "" &&
				prenom != null &&
				telephone != "" &&
				telephone != null &&
				email != "" &&
				email != null
			) {
				setCookie("user-nom", nom, 1);
				setCookie("user-prenom", prenom, 1);
				setCookie("user-telephone", telephone, 1);
				setCookie("user-email", email, 1);
				$("#connexionModal").modal("hide");
			} else {
				$("#error-form").html("Tous les champs doivent être remplis.");
				$("#error-alert").removeClass("d-none");
				setTimeout(function () {
					$("#error-alert").delay(2000).addClass("d-none");
				}, 2000);
			}
		});
	}
}

export default {
	checkCookie,
	getCookie,
	setCookie,
};
