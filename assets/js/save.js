// Affichage des questions
const url = "/get-questions";
axios.post(url, {}).then(
    (response) => {
        var questions = response.data.questions;


        const questionReceiverBackoffice = document.querySelector("#js-questions-bo");

        questions.forEach(function (question) {
            if (question.questionStatus == true) {
                var switchStatus = "checked";
            }
            console.log(question.questionId);
            var createdReceiver = document.createElement("div");
            createdReceiver.id = "question-card-" + question.questionId;
            createdReceiver.className = "col-md-6 mb-4 question-card";
            createdReceiver.innerHTML += `
                <div class="card shadow-sm" id="card-${question.questionId}">
                    <div class="card-header d-flex">
                        <span class="me-auto">${question.questionPrenom} ${question.questionNom}</span>
                        
                        <a class="js-status">
                            <span class="js-question-status">
                                <div class="form-check form-switch">
                                    <input id="switch-${question.questionId}" class="form-check-input js-question-switch" type="checkbox" data-switch="${question.questionId}" ${switchStatus}>
                                </div>
                            </span>
                        </a>
                        
                        <a class="reply ms-4" href="/answer/question/${question.questionId}" data-bs-toggle="modal" data-bs-target="#answerModal-${question.questionId}">
                            <i class="fal fa-reply text-warning"></i>
                        </a>
                        <a class="js-delete ms-4" data-question="${question.questionId}" id="delete-btn-${question.questionId}">
                            <i class="fal fa-trash-alt text-danger"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <p class="card-text">${question.questionSent}</p>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="answerModal-${question.questionId}" tabindex="-1" aria-labelledby="answerModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="answerModalLabel">${question.questionSent}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="js-answer-${question.questionId}" class="form-label">Votre réponse</label>
                                    <textarea class="form-control" id="js-answer-${question.questionId}" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="button" class="btn btn-primary answer-btn" id="js-answer-button-${question.questionId} " data-question="${question.questionId}" data-bs-dismiss="modal">Envoyer</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            questionReceiverBackoffice.insertBefore(
                createdReceiver,
                questionReceiverBackoffice.firstChild
            );
        });
        


        console.table(response.data.questions);
    },
    (error) => {
        console.log(error);
    }
);