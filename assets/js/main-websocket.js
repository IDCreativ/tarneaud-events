import cookies from "./services/cookies";
import axios from "axios";
import io from "socket.io-client";

function initializeMyWS() {
	// checkConnexion();
}

const checkConnexion = function () {
	// if (
	// 	cookies.getCookie("user-nom") != "" &&
	// 	cookies.getCookie("user-prenom") != "" &&
	// 	cookies.getCookie("user-email") != "" &&
	// 	cookies.getCookie("user-telephone") != ""
	// ) {
	// 	console.log("Utilisateur connecté");
	// 	return true;
	// } else {
	// 	console.log("Utilisateur non connecté");
	// 	return false;
	// }

	// On ne check pas les cookies
	return true;
};

initializeMyWS();

// Websocket
console.log("webSocket loaded");
const socket = io("https://sk3ud.alwaysdata.net", {
	withCredentials: false,
	transportationOptions: {
		polling: {
			extraHeaders: {
				"my-custom-header": "abcd",
			},
		},
	},
});

// Variables de départ
var questionStatus = "none";
var input = document.getElementById("js-message");
var button = document.getElementById("js-send-question");

document.querySelectorAll("a.js-vote-send").forEach(function (link) {
	link.addEventListener("click", sendVote);
});

document.querySelectorAll("a.js-contest-answer-send").forEach(function (link) {
	link.addEventListener("click", sendContestAnswer);
});

if (button) {
	button.addEventListener("click", function (eventClick) {
		eventClick.preventDefault();
		if (checkConnexion() == false) {
			alert("Vous devez être connecté !");
			// cookies.checkCookie();
		} else if (input.value != "") {
			var msgObj = JSON.stringify({
				questionSent: input.value,
				// questionPrenom: cookies.getCookie("user-prenom"),
				// questionNom: cookies.getCookie("user-nom"),
				// questionEmail: cookies.getCookie("user-email"),
				// questionTelephone: cookies.getCookie("user-telephone"),

				questionPrenom: "Prénom",
				questionNom: "Nom",
				questionEmail: "Email",
				questionTelephone: "Téléphone",

			});
			recordQuestion(msgObj);
			input.value = "";
		}
	});
}

var send = function (msgObj) {
	socket.emit("chat message", msgObj);
	input.value = "";
};

var sendOneMoreVote = function (totalVotesObj) {
	socket.emit("One more vote", totalVotesObj);
};

// Réception
var receiveTotalVotes = function (totalVotesObj) {
	var totalVotesReceived = JSON.parse(totalVotesObj);
	$("#total-vote-" + totalVotesReceived.pollID).html(
		totalVotesReceived.totalVotes[1]
	);
};

var receiveQuestion = function (obj) {
	var questionReceiverFront = document.getElementById("js-questions");
	var objReceived = JSON.parse(obj);
	if (questionReceiverFront) {
		questionReceiverFront.innerHTML +=
			"<div class='question' style='display: " +
			questionStatus +
			";' id='question-" +
			objReceived.questionId +
			"'><span>" +
			objReceived.questionSent +
			"</span><div id='js-answers-" +
			objReceived.questionId +
			"'></div>";
	}
};

var receiveDeleteQuestion = function (questionToDelete) {
	document.getElementById("question-" + questionToDelete).remove();
};

var receiveAnswer = function (answer) {
	var answerReceived = JSON.parse(answer);
	if (document.getElementById("question-" + answerReceived.answerQuestionId)) {
		document.getElementById(
			"question-" + answerReceived.answerQuestionId
		).style.display = answerReceived.answerSetStatus;
	}
	if (
		document.getElementById("js-answers-" + answerReceived.answerQuestionId)
	) {
		document.getElementById(
			"js-answers-" + answerReceived.answerQuestionId
		).innerHTML +=
			"<div class='answer' id='anwser-" +
			answerReceived.answerId +
			"'>" +
			answerReceived.answerText +
			"</div>";
	}
};

// Change Visibility and Status
var changeQuestionStatus = function (status) {
	var statusReceived = JSON.parse(status);
	var questionToUpdate = document.getElementById(
		"question-" + statusReceived.questionId
	);
	if (questionToUpdate) {
		if (statusReceived.questionStatus == true) {
			questionToUpdate.style.display = "block";
		} else {
			questionToUpdate.style.display = "none";
		}
	}
};

var changeModuleStatus = function (status) {
	var statusReceived = JSON.parse(status);
	if (statusReceived.moduleSlug != "jeux-concours") {
		if (document.getElementById("nav-" + statusReceived.moduleSlug + "-tab")) {
			if (statusReceived.moduleStatus == true) {
				var tabPanes = document
					.querySelectorAll(".tab-pane")
					.forEach(function (item) {
						item.classList.remove("show");
						item.classList.remove("active");
					});
				var allTabs = document
					.querySelectorAll(".nav-block")
					.forEach(function (item) {
						item.classList.remove("active");
					});
				document.getElementById(
					"nav-" + statusReceived.moduleSlug + "-tab"
				).style.display = "flex";
				document
					.getElementById("nav-" + statusReceived.moduleSlug + "-tab")
					.classList.add("active");
				document
					.getElementById("nav-" + statusReceived.moduleSlug)
					.classList.add("show");
				document
					.getElementById("nav-" + statusReceived.moduleSlug)
					.classList.add("active");
			} else {
				var tabPanes = document
					.querySelectorAll(".tab-pane")
					.forEach(function (item) {
						item.classList.remove("show");
						item.classList.remove("active");
					});
				document.getElementById(
					"nav-" + statusReceived.moduleSlug + "-tab"
				).style.display = "none";
				var allTabs = document
					.querySelectorAll(".nav-block")
					.forEach(function (item) {
						item.classList.remove("active");
					})
				;
				document.getElementById("nav-programme").classList.add("show");
				document.getElementById("nav-programme").classList.add("active");
				document.getElementById("nav-programme-tab").classList.add("active");
			}
		}
	} else {
		if (
			document.getElementById(
				"jeux-concours-container-" + statusReceived.moduleId
			)
		) {
			if (statusReceived.moduleStatus == true) {
				document.getElementById(
					"jeux-concours-container-" + statusReceived.moduleId
				).style.display = "block";
			} else {
				document.getElementById(
					"jeux-concours-container-" + statusReceived.moduleId
				).style.display = "none";
			}
		}
	}
};

var changePollStatus = function (pollStatus) {
	var pollStatusReceived = JSON.parse(pollStatus);
	if (pollStatusReceived.pollStatus == true) {
		document.getElementById(
			"fieldset-" + pollStatusReceived.pollID
		).disabled = false;
		document
			.getElementById("poll-overlay-" + pollStatusReceived.pollID)
			.classList.remove("active");
	} else {
		document.getElementById(
			"fieldset-" + pollStatusReceived.pollID
		).disabled = true;
		document
			.getElementById("poll-overlay-" + pollStatusReceived.pollID)
			.classList.add("active");
	}
};

// Événement
var changeEventStatus = function (eventStatus) {
	var eventStatusReceived = JSON.parse(eventStatus);
	if (
		eventStatusReceived.eventStatus == true &&
		eventStatusReceived.eventEmbeded
	) {
		document.getElementById("fieldset-qr").disabled = false;
		var createdEventReceiver = document.getElementById("js-live-container");
		createdEventReceiver.innerHTML = `
            <div id="video-${eventStatusReceived.videoID}" class="video-container" data-ytid="${eventStatusReceived.youtubeId}">
                <div id="code-video-${eventStatusReceived.videoID}" class="embed-responsive embed-responsive-16by9">
                    ${eventStatusReceived.eventEmbeded}
                </div>
            </div>
        `;
		cookies.checkCookie();
	} else if (eventStatusReceived.eventStatus == false) {
		document.getElementById("fieldset-qr").disabled = true;
		var createdEventReceiver = document.getElementById("js-live-container");
		createdEventReceiver.innerHTML = `
            <div class="waiting-block">
                <div id="disclaimer" class="alert alert-danger text-center" role="alert">
                    De retour prochainement.
                </div>
                <img src="img/default/waiting-bg.jpg" alt="">
            </div>
        `;
	} else {
		if (eventStatusReceived.eventStatus == true) {
			document.getElementById("fieldset-qr").disabled = false;
		} else {
			document.getElementById("fieldset-qr").disabled = true;
		}
		var createdEventReceiver = document.getElementById("js-live-container");
		createdEventReceiver.innerHTML = `
            <div class="waiting-block">
                <div id="disclaimer" class="alert alert-danger text-center" role="alert">
                    De retour prochainement.
                </div>
                <img src="img/default/waiting-bg.jpg" alt="">
            </div>
        `;
	}
};

// Vidéos
var changeVideoStatus = function (videoStatus) {
	var videoStatusReceived = JSON.parse(videoStatus);
	var createdEventReceiver = document.getElementById("js-live-container");
	if (
		videoStatusReceived.eventStatus == true &&
		videoStatusReceived.videoStatus == true &&
		videoStatusReceived.eventVideo == videoStatusReceived.videoID
	) {
		createdEventReceiver.innerHTML = `
            <div id="video-${videoStatusReceived.eventVideo}" class="video-container" data-ytid="${videoStatusReceived.youtubeId}">
                <div id="code-video-${videoStatusReceived.eventVideo}" class="embed-responsive embed-responsive-16by9">
                    ${videoStatusReceived.videoEmbeded}
                </div>
            </div>
        `;
	} else if (
		videoStatusReceived.eventStatus == true &&
		videoStatusReceived.videoStatus == false &&
		videoStatusReceived.videoPosition < videoStatusReceived.eventVideoPosition
	) {
		createdEventReceiver.innerHTML = `
            <div id="video-${videoStatusReceived.eventVideo}" class="video-container" data-ytid="${videoStatusReceived.youtubeId}">
                <div id="code-video-${videoStatusReceived.eventVideo}" class="embed-responsive embed-responsive-16by9">
                    ${videoStatusReceived.videoEmbeded}
                </div>
            </div>
        `;
	} else if (videoStatusReceived.eventVideo == false) {
		createdEventReceiver.innerHTML = `
            <div class="waiting-block">
                <div id="disclaimer" class="alert alert-danger text-center" role="alert">
                    De retour prochainement.
                </div>
                <img src="img/default/waiting-bg.jpg" alt="">
            </div>
        `;
	} else {
		console.log("Tous les autres cas");
	}
};

// Sondages
var changePollVisibility = function (pollVisibility) {
	var pollVisibilityReceived = JSON.parse(pollVisibility);
	if (pollVisibilityReceived.pollVisibility == true) {
		document.getElementById(
			"poll-" + pollVisibilityReceived.pollID
		).style.display = "block";
	} else {
		document.getElementById(
			"poll-" + pollVisibilityReceived.pollID
		).style.display = "none";
	}
};

var showPollResults = function (pollID) {
	checkOptionTotal();
	if ($("#poll-resultats-" + pollID).hasClass("d-none")) {
		$("#poll-resultats-" + pollID).removeClass("d-none");
		$("#poll-options-" + pollID).addClass("d-none");
	} else {
		$("#poll-resultats-" + pollID).addClass("d-none");
		$("#poll-options-" + pollID).removeClass("d-none");
	}
};

// Récupération des résultats des sondages
function checkOptionTotal() {
	$(".js-option").each(function (index, item) {
		var optionId = item.id;
		var url = "/poll-option-total/id/" + optionId;
		axios
			.get(url)
			.then((response) => {
				item.innerHTML = response.data.total[1];
				totalVotes = response.data.totalVotes[1];
				if (totalVotes == null) {
					totalVotes = 0;
				}
				$("#total-vote-" + response.data.pollId).html(" " + totalVotes);
			})
			.catch(function (error) {
				if (error) {
					console.log(error);
				}
			});
	});
}

var changeContestStatus = function (contestStatus) {
	var contestStatusReceived = JSON.parse(contestStatus);
	var hideAllContainers = function () {
		document.querySelectorAll(".js-contest-container").forEach(function (item) {
			if (item.classList.contains("block-visible")) {
				item.classList.remove("block-visible");
				item.classList.add("block-invisible");
			}
		});
	};

	switch (contestStatusReceived.contestQuestionStatus) {
		case 0:
			hideAllContainers();
			document.getElementById("contestStatus-0").classList.remove("block-invisible");
			document.getElementById("contestStatus-0").classList.add("block-visible");
			break;
		case 1:
			hideAllContainers();
			document.getElementById("contestStatus-1").classList.remove("block-invisible");
			document.getElementById("contestStatus-1").classList.add("block-visible");
			break;
		case 2:
			hideAllContainers();
			document.getElementById("contestStatus-2").classList.remove("block-invisible");
			document.getElementById("contestStatus-2").classList.add("block-visible");
			break;
	}
};

var changeContestQuestionStatus = function (contestQuestionStatus) {
	console.log("changeContestQuestionStatus");
	console.log(contestQuestionStatus);
};

// Websocket receive informations

socket.on("chat message", receiveQuestion);
socket.on("change status", changeQuestionStatus);
socket.on("change moduleStatus", changeModuleStatus);
socket.on("change eventStatus", changeEventStatus);
socket.on("change videoStatus", changeVideoStatus);
socket.on("change pollStatus", changePollStatus);
socket.on("change pollVisibility", changePollVisibility);
socket.on("show pollResults", showPollResults);
socket.on("chat answer", receiveAnswer);
socket.on("delete question", receiveDeleteQuestion);
socket.on("One more vote", receiveTotalVotes);
socket.on("change contestStatus", changeContestStatus);
socket.on("change contestQuestionStatus", changeContestQuestionStatus);

// Envoi et enregistrement des informations
// Questions
function recordQuestion(msgObj) {
	var messageQuestion = JSON.parse(msgObj);
	if (messageQuestion.questionSent == "") {
		alert("Vous devez remplir le champ 'Question' !");
	} else {
		const url = "/send-question";
		axios
			.post(url, {
				questionSent: messageQuestion.questionSent,
				firstname: messageQuestion.questionPrenom,
				lastname: messageQuestion.questionNom,
				telephone: messageQuestion.questionTelephone,
				email: messageQuestion.questionEmail,
			})
			.then(
				(response) => {
					msgObj = JSON.stringify({
						questionId: response.data.id,
						questionSent: response.data.questionSent,
						questionNom: response.data.questionNom,
						questionPrenom: response.data.questionPrenom,
						questionEmail: response.data.questionEmail,
					});
					send(msgObj);
				},
				(error) => {
					console.log(error);
				}
			);
		messageQuestion.value = "";

		$("#question-sent").toast("show");
		$("#js-question-sent").html(
			"Votre question a bien été envoyée. Si vous n'avez pas la réponse durant la web-conférence, vous serez recontacté par e-mail ou par téléphone."
		);
	}
}

// Votes
function sendVote(event) {
	event.preventDefault();

	var pollId = this.id;
	var pollValue = document.querySelector(
		'input[name="poll-vote-' + CSS.escape(pollId) + '"]:checked'
	).value;
	const url = "/send-vote";
	axios
		.post(url, {
			voteOptionId: pollValue,
			votePoll: pollId,
		})
		.then(
			(response) => {
				if (response.data.code == 200) {
					$("#vote-sent").modal("show");
					setTimeout(function () {
						$("#vote-sent").modal("hide");
					}, 3000);
					$("#js-vote-sent").html(response.data.message);
					var totalVotesObj = JSON.stringify({
						pollID: response.data.pollID,
						totalVotes: response.data.totalVotes,
					});
					sendOneMoreVote(totalVotesObj);
				} else if (response.data.code == 403) {
					$("#vote-sent").modal("show");
					$("#js-vote-sent").html("Accès interdit");
				}
			},
			(error) => {
				console.log(error);
			}
		);
}

// Jeux-concours
function sendContestAnswer(event) {
	event.preventDefault();
	document.querySelectorAll(".contest-answer-input").forEach(function (input) {
		if (checkConnexion() == false) {
			alert("Vous devez être connecté !");
			cookies.checkCookie();
		} else if (input.checked) {
			const url = "/send-answer-contest";
			axios
				.post(url, {
					contestOption: input.value,
					contestQuestion: input.dataset.question,
					// firstname: cookies.getCookie("user-prenom"),
					// lastname: cookies.getCookie("user-nom"),
					// email: cookies.getCookie("user-email"),
					// telephone: cookies.getCookie("user-telephone"),
				})
				.then((response) => {
					if (response.data.code == 200) {
						$("#contest-answer-sent-" + input.dataset.question).toast("show");
						setTimeout(function () {
							$("#contest-answer-sent-" + input.dataset.question).toast("hide");
						}, 3000);
						$("#js-contest-answer-sent-" + input.dataset.question).html(
							response.data.message
						);
					} else {
						$("#contest-answer-sent-" + input.dataset.question).toast("show");
						$("#js-contest-answer-sent-" + input.dataset.question).html(
							"Une erreur s'est produite."
						);
					}
				});
		}
	});
}
