import axios from "axios";
import io from "socket.io-client";

// Connexion au Websocket
console.log("webSocket Back Office loaded from TWIG");
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

const initFunction = function () {
	prepareQuestionsInteractions();
};

initFunction();

// Envoi des information vers WS
var sendAnswer = function (msgObj) {
	socket.emit("chat answer", msgObj);
};

var sendQuestionStatus = function (status) {
	socket.emit("change status", status);
};

var sendEventStatus = function (eventStatus) {
	socket.emit("change eventStatus", eventStatus);
};

var sendContestStatus = function (contestStatus) {
	socket.emit("change contestStatus", contestStatus);
};

var sendContestQuestionStatus = function (contestQuestionStatus) {
	socket.emit("change contestQuestionStatus", contestQuestionStatus);
};

var sendVideoStatus = function (videoStatus) {
	socket.emit("change videoStatus", videoStatus);
};

var sendPollStatus = function (pollStatus) {
	socket.emit("change pollStatus", pollStatus);
};

var sendPollVisibility = function (pollVisibility) {
	socket.emit("change pollVisibility", pollVisibility);
};

var sendModuleStatus = function (moduleStatus) {
	socket.emit("change moduleStatus", moduleStatus);
};

var sendQuestionDelete = function (deleteQuestion) {
	socket.emit("delete question", deleteQuestion);
};

var sendPollResults = function (pollResults) {
	socket.emit("show pollResults", pollResults);
};
// Fin des envois vers WS

// Événement Switch
const eventSwitches = document.querySelectorAll(".js-event-switch");
eventSwitches.forEach((eventSwitch) => {
	eventSwitch.addEventListener("click", function () {
		setEventStatus(eventSwitch.dataset.event);
	});
});

// Vidéos Switchs
const videoSwitches = document.querySelectorAll(".js-video-switch");
videoSwitches.forEach((videoSwitch) => {
	videoSwitch.addEventListener("click", function () {
		setVideoStatus(videoSwitch.dataset.video);
	});
});

// Modules Switchs
const moduleSwitches = document.querySelectorAll(".js-module-switch");
moduleSwitches.forEach(function (moduleSwitch) {
	moduleSwitch.addEventListener("change", function () {
		setModuleStatus(moduleSwitch.dataset.switch);
	});
});

// Questions interactions
function prepareQuestionsInteractions() {
	var deleteQuestionButtons = document.querySelectorAll(".js-delete");
	var questionSwitches = document.querySelectorAll(".js-question-switch");
	var answerButtons = document.querySelectorAll(".answer-btn");

	// Questions Delete
	// var deleteQuestionButtons = document.querySelectorAll(".js-delete");
	deleteQuestionButtons.forEach(function (deleteQuestionButton) {
		deleteQuestionButton.addEventListener("click", function () {
			deleteQuestion(deleteQuestionButton.dataset.question);
		});
	});

	// Questions Switchs
	// var questionSwitches = document.querySelectorAll(".js-question-switch");
	questionSwitches.forEach(function (questionSwitch) {
		questionSwitch.addEventListener("change", function () {
			setQuestionStatus(questionSwitch.dataset.switch);
		});
	});

	// Record answer
	// var answerButtons = document.querySelectorAll(".answer-btn");
	answerButtons.forEach(function (answerButton) {
		answerButton.addEventListener("click", function () {
			recordAnswer(answerButton.dataset.question);
		});
	});
}

// Jeux-concours interactions
// Jeux-concours Turn OFF
const contestSwitch = document.querySelectorAll(".js-contest-switch-off");
contestSwitch.forEach(function (contestSwitch) {
	contestSwitch.addEventListener("click", function () {
		setContestStatus(contestSwitch.dataset.contest);
	});
});

// Jeux-concours Switch
const contestSwitchQuestions = document.querySelectorAll(".js-contest-switch");
contestSwitchQuestions.forEach(function (contestSwitchQuestion) {
	contestSwitchQuestion.addEventListener("change", function () {
		setContestStatusSwitch(contestSwitchQuestion.dataset.contest);
	});
});

// Jeux-concours Questions Switchs
const contestQuestionSwitches = document.querySelectorAll(".js-contest-question-switch");
contestQuestionSwitches.forEach(function (contestQuestionSwitch) {
	contestQuestionSwitch.addEventListener("click", function () {
		setContestQuestionStatus(contestQuestionSwitch.dataset.question);
	});
});

// Sondarges interactions
// Sondages Visibility
const pollSwitches = document.querySelectorAll(".js-poll-switch");
pollSwitches.forEach(function (pollSwitch) {
	pollSwitch.addEventListener("click", function () {
		setPollVisibility(pollSwitch.dataset.poll);
	});
});

// Sondage Status
const pollStatusSwitches = document.querySelectorAll(".js-poll-status-switch");
pollStatusSwitches.forEach(function (pollStatusSwitch) {
	pollStatusSwitch.addEventListener("change", function () {
		setPollStatus(pollStatusSwitch.dataset.poll);
	});
});

// Sondages Results
const pollResultsButtons = document.querySelectorAll(".js-pollresults");
pollResultsButtons.forEach(function (pollResultsButton) {
	pollResultsButton.addEventListener("click", function () {
		showPollResults(pollResultsButton.dataset.poll);
	});
});

// Fonctions appelées par les boutons/switchs

function setModuleStatus(moduleId) {
	const url = "/change-module-status/" + moduleId;
	axios.post(url, {}).then(
		(response) => {
			var moduleStatusInfos = JSON.stringify({
				moduleId: response.data.id,
				moduleStatus: response.data.status,
				moduleSlug: response.data.slug,
			});
			sendModuleStatus(moduleStatusInfos);
		},
		(error) => {
			console.log(error);
		}
	);
}

function setEventStatus(eventID) {
	const url = "/change-event-status/" + eventID;
	axios.post(url, {}).then(
		(response) => {
			var eventStatusInfos = JSON.stringify({
				eventID: response.data.id,
				eventStatus: response.data.status,
				eventEmbeded: response.data.embed,
				videoID: response.data.videoID,
			});
			console.table(response.data);
			sendEventStatus(eventStatusInfos);
		},
		(error) => {
			console.log(error);
		}
	);
}

function setVideoStatus(videoID) {
	const url = "/change-video-status/" + videoID;
	axios.post(url, {}).then(
		(response) => {
			var videoStatusInfos = JSON.stringify({
				videoID: response.data.id,
				videoStatus: response.data.status,
				videoEmbeded: response.data.embed,
				eventStatus: response.data.eventStatus,
				eventVideo: response.data.eventVideo,
				youtubeId: response.data.youtubeId,
				videoPosition: response.data.videoPosition,
				eventVideoPosition: response.data.eventVideoPosition,
			});
			console.table(response.data);
			sendVideoStatus(videoStatusInfos);
		},
		(error) => {
			console.log(error);
		}
	);
}

// Questions
var receiveQuestion = function (obj) {
	var questionReceiverBackoffice = document.getElementById("js-questions-bo");
	var objReceived = JSON.parse(obj);
	if (questionReceiverBackoffice) {
		if (objReceived.questionStatus == true) {
			var switchStatus = "checked";
		}
		var createdReceiver = document.createElement("div");
		createdReceiver.id = "question-card-" + objReceived.questionId;
		createdReceiver.className = "col-md-6 mb-4 question-card";
		createdReceiver.innerHTML += `
            <div class="card" id="card-${objReceived.questionId}">
                <div class="card-header d-flex">
                    <span class="me-auto">${objReceived.questionPrenom} ${objReceived.questionNom}</span>
                    
                    <a class="js-status">
                        <span class="js-question-status">
                            <div class="form-check form-switch">
                                <input class="form-check-input js-question-switch" type="checkbox" data-switch="${objReceived.questionId}" id="switch-${objReceived.questionId}" ${switchStatus}>
                            </div>
                        </span>
                    </a>
                    
                    <a class="reply ms-4" href="/answer/question/${objReceived.questionId}" data-bs-toggle="modal" data-bs-target="#answerModal-${objReceived.questionId}">
                        <i class="fal fa-reply text-warning"></i>
                    </a>
                    <a class="js-delete ms-4" data-question="${objReceived.questionId}" id="delete-btn-${objReceived.questionId}">
                        <i class="fal fa-trash-alt text-danger"></i>
                    </a>
                </div>
                <div class="card-body">
                    <p class="card-text">${objReceived.questionSent}</p>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="answerModal-${objReceived.questionId}" tabindex="-1" aria-labelledby="answerModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="answerModalLabel">${objReceived.questionSent}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="js-answer-${objReceived.questionId}" class="form-label">Votre réponse</label>
                                <textarea class="form-control" id="js-answer-${objReceived.questionId}" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-primary answer-btn" id="js-answer-button-${objReceived.questionId} " data-question="${objReceived.questionId}" data-bs-dismiss="modal">Envoyer</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
		questionReceiverBackoffice.insertBefore(
			createdReceiver,
			questionReceiverBackoffice.firstChild
		);
		prepareQuestionsInteractions();
	}
};
socket.on("chat message", receiveQuestion);

function setQuestionStatus(questionId) {
	const url = "/change-question-status/" + questionId;
	axios.post(url, {}).then(
		(response) => {
			var questionStatusInfos = JSON.stringify({
				questionId: response.data.id,
				questionStatus: response.data.status,
			});
			sendQuestionStatus(questionStatusInfos);
		},
		(error) => {
			console.log(error);
		}
	);
}

function deleteQuestion(questionToDelete) {
	if (confirm("Êtes-vous certain de vouloir supprimer cet élément ?")) {
		const url = "/dashboard/question-remove/" + questionToDelete;
		axios.post(url, {}).then(
			(response) => {
				if (response.data.status == true) {
					document.getElementById("question-card-" + questionToDelete).remove();
					sendQuestionDelete(questionToDelete);
				}
			},
			(error) => {
				console.log(error);
			}
		);
	}
}

function recordAnswer(questionId) {
	const url = "/answer/question/" + questionId;
	axios
		.post(url, {
			answerText: document.getElementById("js-answer-" + questionId).value,
			answerQuestionId: questionId,
		})
		.then(
			(response) => {
				var msgObj = JSON.stringify({
					answerText: response.data.answer,
					answerQuestionId: response.data.questionId,
					answerId: response.data.id,
					answerSetStatus: "block",
				});
				sendAnswer(msgObj);
				$("#card-" + response.data.questionId)
					.find(".fa-reply")
					.removeClass("text-warning")
					.addClass("text-success");
				document.getElementById(
					"switch-" + response.data.questionId
				).checked = true;
			},
			(error) => {
				console.log(error);
			}
		);
}

// Sondages
function setPollStatus(pollID) {
	const url = "/change-poll-status/" + pollID;
	axios.post(url, {}).then(
		(response) => {
			var pollStatusInfos = JSON.stringify({
				pollID: response.data.id,
				pollStatus: response.data.status,
			});
			sendPollStatus(pollStatusInfos);
		},
		(error) => {
			console.log(error);
		}
	);
}

function setPollVisibility(pollID) {
	const url = "/change-poll-visibility/" + pollID;
	axios.post(url, {}).then(
		(response) => {
			var pollVisibilityInfos = JSON.stringify({
				pollID: response.data.id,
				pollVisibility: response.data.visibility,
			});
			sendPollVisibility(pollVisibilityInfos);
		},
		(error) => {
			console.log(error);
		}
	);
	var monOeil = document.getElementById("poll-visible-" + pollID);
	if (monOeil.dataset.visible === "true") {
		monOeil.setAttribute("data-visible", false);
		monOeil.classList.replace("btn-success", "btn-outline-dark");
		monOeil.innerHTML = '<i class="fal fa-eye-slash fa-fw"></i>';
	} else {
		monOeil.setAttribute("data-visible", true);
		monOeil.classList.replace("btn-outline-dark", "btn-success");
		monOeil.innerHTML = '<i class="fal fa-eye fa-fw"></i>';
	}
}

function showPollResults(pollID) {
	sendPollResults(pollID);

	if (document.getElementById("poll-switch-" + pollID).checked == true) {
		const url = "/change-poll-status/" + pollID;
		axios.post(url, {}).then(
			(response) => {
				var pollStatusInfos = JSON.stringify({
					pollID: response.data.id,
					pollStatus: response.data.status,
				});
				sendPollStatus(pollStatusInfos);
			},
			(error) => {
				console.log(error);
			}
		);
	}
	document.getElementById("poll-switch-" + pollID).checked = false;
	var pollResultsIcon = document.getElementById("poll-results-" + pollID);
	if (pollResultsIcon.dataset.results === "true") {
		pollResultsIcon.setAttribute("data-results", false);
		pollResultsIcon.classList.replace("btn-success", "btn-outline-dark");
	} else {
		pollResultsIcon.setAttribute("data-results", true);
		pollResultsIcon.classList.replace("btn-outline-dark", "btn-success");
	}
}

// Jeux-concours
function setContestStatus(contestID) {
	const url = "/change-contest-status/" + contestID;
	axios.post(url, {
		contestID: contestID,
		contestQuestionStatus: 2
	}).then(
		(response) => {
			var contestStatusInfos = JSON.stringify({
				contestID: response.data.id,
				contestQuestionStatus: response.data.status,
			});
			sendContestStatus(contestStatusInfos);
			document.getElementById("js-contest-switch-" + contestID).checked = false;
		},
		(error) => {
			console.log(error);
		}
	);
}

function setContestStatusSwitch(contestID) {
	const url = "/change-contest-status/" + contestID;
	var contestQuestionStatus = document.getElementById("js-contest-switch-" + contestID).checked ? 1 : 0;
	axios.post(url, {
		contestID: contestID,
		contestQuestionStatus: contestQuestionStatus
	}).then(
		(response) => {
			var contestStatusInfos = JSON.stringify({
				contestID: response.data.id,
				contestQuestionStatus: response.data.status,
			});
			sendContestStatus(contestStatusInfos);
		},
		(error) => {
			console.log(error);
		}
	);
}

function setContestQuestionStatus(contestQuestionID) {
	const url = "/change-contest-question-status/" + contestQuestionID;
	axios.post(url, {}).then(
		(response) => {
			var contestQuestionStatusInfos = JSON.stringify({
				contestQuestionID: response.data.id,
				contestQuestionStatus: response.data.status,
			});
			sendContestQuestionStatus(contestQuestionStatusInfos);
		},
		(error) => {
			console.log(error);
		}
	);
	var contestQuestionEye = document.getElementById(
		"contest-question-visible-" + contestQuestionID
	);
	if (contestQuestionEye.dataset.visible === "true") {
		contestQuestionEye.setAttribute("data-visible", false);
		contestQuestionEye.classList.replace("btn-success", "btn-outline-dark");
		contestQuestionEye.innerHTML = '<i class="fal fa-eye-slash fa-fw"></i>';
	} else {
		contestQuestionEye.setAttribute("data-visible", true);
		contestQuestionEye.classList.replace("btn-outline-dark", "btn-success");
		contestQuestionEye.innerHTML = '<i class="fal fa-eye fa-fw"></i>';
	}
}
