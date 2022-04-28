import moment from "moment";
import "moment/locale/fr";
import "moment-timezone";
import countdown from "./services/countdown";
import cookies from "./services/cookies";
import axios from "axios";

function initializeMyJS() {
	console.log("mainJS loaded");
	const eventActive = axios
		.get("/config-json")
		.then((response) => {
			console.log("response.data", response.data);
			if(response.data.event && response.data.event.public === false) {
				console.log(response.data.event );
				// cookies.checkCookie();
			}
		})
		.catch(function (error) {
			if (error) {
				console.log(error);
			}
		})
	;
	
}

// setInterval(() => {
// 	countdown();
// }, 1000);

initializeMyJS();

const asideToggle = document.getElementById("aside-toggle");
const mainContainer = document.getElementById("main-container");
const sideBar = document.getElementById("sidebar");

asideToggle.addEventListener("click", function () {
	asideToggle.classList.toggle("aside-opened");
	mainContainer.classList.toggle("aside-opened");
	sideBar.classList.toggle("aside-opened");
	
	console.log("on ouvre/ferme aside");
});
