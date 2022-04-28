import moment from "moment";
import "moment/locale/fr";
import "moment-timezone";

function countdown(date) {
	const Affiche = document.getElementById("countdown");
	const Titre = document.getElementById("countdown-title");

	var date1 = new Date();
	var date2 = new Date("Mar 17, 2022 19:00:00");
	// console.log(date1);
	var sec = (date2 - date1) / 1000;
	var n = 24 * 3600;
	if (sec > 0) {
		var j = Math.floor(sec / n);
		var h = Math.floor((sec - j * n) / 3600);
		var mn = Math.floor((sec - (j * n + h * 3600)) / 60);
		sec = Math.floor(sec - (j * n + h * 3600 + mn * 60));
		if (Affiche) {
			Affiche.innerHTML =
				j +
				" <span>j</span> " +
				h +
				" <span>h</span> " +
				mn +
				" <span>min</span> " +
				sec +
				" <span>s</span>"
			;
		}
	} else if (sec < 0) {
		Titre.innerHTML = "Événement terminé.";
		Affiche.innerHTML = "<p class='car-ended'>RDV très prochainement.</p>";
	} else {
		Affiche.innerHTML =
			"<p class='car-ended'>Événement commencé. Pensez à raffraichir la page (CTRL+F5 sur PC, CMD+R sur Mac).</p>";
	}
}

export default countdown;
