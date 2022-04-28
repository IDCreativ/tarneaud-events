<?php

namespace App\Controller;

use App\Entity\Poll;
use App\Entity\Event;
use App\Entity\Video;
use App\Entity\Answer;
use App\Entity\Module;
use App\Entity\Contest;
use App\Entity\PollVote;
use App\Entity\Question;
use App\Entity\PageConfig;
use App\Entity\PollOption;
use App\Entity\ContestEntry;
use App\Entity\ContestQuestion;
use App\Repository\PollRepository;
use App\Repository\EventRepository;
use App\Repository\VideoRepository;
use App\Repository\CategoryRepository;
use App\Repository\PartnersRepository;
use App\Repository\PollVoteRepository;
use App\Repository\QuestionRepository;
use App\Repository\ProgrammeRepository;
use App\Repository\PollOptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ContestEntryRepository;
use App\Repository\ContestOptionRepository;
use App\Repository\ContestQuestionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\GeneralConfigurationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JsonController extends AbstractController
{
    private $videoRepository;
    private $questionRepository;
    private $generalConfigurationRepository;
    private $categoryRepository;
    private $eventRepository;
    private $partnersRepository;
    private $programmeRepository;
    private $pollRepository;
    private $pollOptionRepository;
    private $pollVoteRepository;
    private $entityManager;
    private $contestOptionRepository;
    private $contestQuestionRepository;
    private $contestEntryRepository;

    public function __construct(
        GeneralConfigurationRepository $generalConfigurationRepository,
        VideoRepository $videoRepository,
        QuestionRepository $questionRepository,
        CategoryRepository $categoryRepository,
        PartnersRepository $partnersRepository,
        EventRepository $eventRepository,
        ProgrammeRepository $programmeRepository,
        PollRepository $pollRepository,
        PollOptionRepository $pollOptionRepository,
        PollVoteRepository $pollVoteRepository,
        EntityManagerInterface $entityManager,
        ContestOptionRepository $contestOptionRepository,
        ContestQuestionRepository $contestQuestionRepository,
        ContestEntryRepository $contestEntryRepository
    ) {
        $this->generalConfigurationRepository = $generalConfigurationRepository;
        $this->videoRepository = $videoRepository;
        $this->questionRepository = $questionRepository;
        $this->categoryRepository = $categoryRepository;
        $this->eventRepository = $eventRepository;
        $this->partnersRepository = $partnersRepository;
        $this->programmeRepository = $programmeRepository;
        $this->pollRepository = $pollRepository;
        $this->pollOptionRepository = $pollOptionRepository;
        $this->pollVoteRepository = $pollVoteRepository;
        $this->entityManager = $entityManager;
        $this->contestOptionRepository = $contestOptionRepository;
        $this->contestQuestionRepository = $contestQuestionRepository;
        $this->contestEntryRepository = $contestEntryRepository;
    }

    /**
     * @Route("/send-question", name="send_question")
     */
    public function send_question(Request $request): Response
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        $question = new Question;
        $question
            ->setQuestion($data['questionSent'])
            ->setFirstname($data['firstname'])
            ->setLastname($data['lastname'])
            ->setEmail($data['email'])
            ->setTelephone($data['telephone']);
        $this->entityManager->persist($question);
        $this->entityManager->flush();

        return $this->json([
            'code'              => 200,
            'id'                => $question->getId(),
            'questionSent'      => $question->getQuestion(),
            'questionNom'       => $question->getLastname(),
            'questionPrenom'    => $question->getFirstname(),
            'questionEmail'     => $question->getEmail()

        ], 200);
    }

    /**
     * @Route("/change-question-status/{id}", name="change_question_status")
     */
    public function change_question_status(Question $question, Request $request): Response
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        if ($question->getStatus() == true) {
            $question->setStatus(false);
        } else {
            $question->setStatus(true);
        }
        $this->entityManager->persist($question);
        $this->entityManager->flush();

        return $this->json([
            'code'      => 200,
            'message'   => 'Succès',
            'status'    => $question->getStatus(),
            'id'        => $question->getId()
        ]);
    }

    /**
     * @Route("/change-contest-status/{id}", name="change_contest_status")
     */
    public function change_contest_status(Contest $contest, Request $request): Response
    {
        $data = $request->getContent();
        $data = json_decode($data, true);
        
        $contest->setQuestionStatus($data['contestQuestionStatus']);

        $this->entityManager->persist($contest);
        $this->entityManager->flush();

        return $this->json([
            'code'      => 200,
            'message'   => 'Succès',
            'status'    => $contest->getQuestionStatus(),
            'id'        => $contest->getId()
        ]);
    }

    /**
     * @Route("/change-contest-question-status/{id}", name="change_contest_question_status")
     */
    public function change_contest_question_status(ContestQuestion $contestQuestion, Request $request): Response
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        if ($contestQuestion->getStatus() == true) {
            $contestQuestion->setStatus(false);
        } else {
            $contestQuestion->setStatus(true);
        }
        $this->entityManager->persist($contestQuestion);
        $this->entityManager->flush();

        return $this->json([
            'code'      => 200,
            'message'   => 'Succès',
            'status'    => $contestQuestion->getStatus(),
            'id'        => $contestQuestion->getId()
        ]);
    }

    /**
     * @Route("/change-module-status/{id}", name="change_module_status")
     */
    public function change_module_status(Module $module, Request $request): Response
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        if ($module->getActive() == true) {
            $module->setActive(false);
        } else {
            $module->setActive(true);
        }
        $this->entityManager->persist($module);
        $this->entityManager->flush();

        return $this->json([
            'code'      => 200,
            'message'   => 'Succès',
            'status'    => $module->getActive(),
            'slug'    => $module->getSlug(),
            'id'        => $module->getId()
        ]);
    }

    /**
     * @Route("/change-event-status/{id}", name="change_event_status")
     */
    public function change_event_status(Event $event, Request $request): Response
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        if ($event->getActive() == true) {
            $event->setActive(false);
        } else {
            $event->setActive(true);
        }
        $this->entityManager->persist($event);
        $this->entityManager->flush();

        if ($this->generalConfigurationRepository->findLast() != null && $this->videoRepository->findOneByEvent($this->generalConfigurationRepository->findLast()->getEvent()) != null) {
            $embed = $this->videoRepository->findOneByEvent($this->generalConfigurationRepository->findLast()->getEvent())->getEmbedCode();
            $videoId = $this->videoRepository->findOneByEvent($this->generalConfigurationRepository->findLast()->getEvent())->getId();
        } else {
            $embed = false;
            $videoId = false;
        }

        return $this->json([
            'code'      => 200,
            'message'   => 'Succès',
            'status'    => $event->getActive(),
            'id'        => $event->getId(),
            'embed'     => $embed,
            'videoID'   => $videoId
        ]);
    }

    /**
     * @Route("/change-video-status/{id}", name="change_video_status")
     */
    public function change_video_status(Video $video, Request $request): Response
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        if ($video->getStatus() == true) {
            $video->setStatus(false);
        } else {
            $video->setStatus(true);
        }
        $this->entityManager->persist($video);
        $this->entityManager->flush();

        if ($this->generalConfigurationRepository->findLast() != null && $this->videoRepository->findOneByEvent($this->generalConfigurationRepository->findLast()->getEvent()) != null) {
            $embed = $this->videoRepository->findOneByEvent($this->generalConfigurationRepository->findLast()->getEvent())->getEmbedCode();
            $videoId = $this->videoRepository->findOneByEvent($this->generalConfigurationRepository->findLast()->getEvent())->getId();
            $youtubeId = $this->videoRepository->findOneByEvent($this->generalConfigurationRepository->findLast()->getEvent())->getYoutubeId();
            $eventVideoPosition = $this->videoRepository->findOneByEvent($this->generalConfigurationRepository->findLast()->getEvent())->getPosition();
        } else {
            $embed = false;
            $videoId = false;
            $youtubeId = false;
            $eventVideoPosition = false;
        }

        return $this->json([
            'code'                  => 200,
            'message'               => 'Succès',
            'status'                => $video->getStatus(),
            'id'                    => $video->getId(),
            'eventStatus'           => $video->getEvent()->getActive(),
            'eventVideo'            => $videoId,
            'embed'                 => $embed,
            'youtubeId'             => $youtubeId,
            'videoPosition'         => $video->getPosition(),
            'eventVideoPosition'    => $eventVideoPosition
        ]);
    }

    /**
     * @Route("/change-poll-status/{id}", name="change_poll_status")
     */
    public function change_poll_status(Poll $poll, Request $request): Response
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        if ($poll->getStatus() == true) {
            $poll->setStatus(false);
        } else {
            $poll->setStatus(true);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($poll);
        $entityManager->flush();

        return $this->json([
            'code'      => 200,
            'message'   => 'Succès',
            'status'    => $poll->getStatus(),
            'id'        => $poll->getId()
        ]);
    }

    /**
     * @Route("/change-poll-visibility/{id}", name="change_poll_visibility")
     */
    public function change_poll_visibility(Poll $poll, Request $request): Response
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        if ($poll->getVisibility() == true) {
            $poll->setVisibility(false);
        } else {
            $poll->setVisibility(true);
        }
        $this->entityManager->persist($poll);
        $this->entityManager->flush();

        return $this->json([
            'code'      => 200,
            'message'   => 'Succès',
            'visibility'    => $poll->getVisibility(),
            'id'        => $poll->getId()
        ]);
    }

    /**
     * @Route("/poll-option-total/id/{id}", name="poll_option_total")
     */
    public function poll_option_total(PollOption $pollOption)
    {
        $total = $this->pollVoteRepository->findByOption($pollOption);
        $globalVotes = $this->pollVoteRepository->findByPoll($pollOption->getPoll());

        return $this->json([
            'total' => $total,
            'totalVotes' => $globalVotes,
            'pollId' => $pollOption->getPoll()->getId()
        ]);
    }

    /**
     * @Route("/answer/question/{id}", name="answer_question")
     */
    public function answer_question(Question $question, Request $request): Response
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        $answer = new Answer;
        $answer->setQuestion($question);
        $answer->setAnswer($data['answerText']);
        $question->setStatus(true);
        $this->entityManager->persist($answer);
        $this->entityManager->persist($question);
        $this->entityManager->flush();
        return $this->json([
            'id'                => $answer->getId(),
            'questionId'        => $answer->getQuestion()->getId(),
            'answer'            => $data['answerText'],
            'answerSetStatus'   => 'block'
        ]);
    }

    /**
     * @Route("/dashboard/question-remove/{id}", name="question_remove")
     */
    public function question_remove(Question $question, Request $request)
    {
        $this->entityManager->remove($question);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'La question est bien supprimée',
            'status' => true
        ]);
    }

    /**
     * @Route("/send-vote", name="send_vote")
     */
    public function send_vote(Request $request): Response
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        $poll = $this->pollRepository->findById(intval($data['votePoll']));
        $pollOption = $this->pollOptionRepository->findById(intval($data['voteOptionId']));
        $isVoted = $this->pollVoteRepository->findByUserAndPoll($this->getUser(), $poll);

        if (!$isVoted) {
            $vote = new PollVote;
            $vote->setUser($this->getUser());
            $vote->setPoll($poll);
            $vote->setPollOption($pollOption);
            $this->entityManager->persist($vote);
            $this->entityManager->flush();

            $globalVotes = $this->pollVoteRepository->findByPoll($poll);

            return $this->json([
                'code' => 200,
                'message' => 'Votre vote a bien été envoyé.',
                // 'prénom' => $this->getUser()->getFirstname(),
                // 'nom' => $this->getUser()->getLastname(),
                // 'email' => $this->getUser()->getEmail(),
                'pollID' => $data['votePoll'],
                'optionID' => $data['voteOptionId'],
                'totalVotes' => $globalVotes
            ], 200);
        } else {
            $vote = $this->pollVoteRepository->findByUserAndPoll($this->getUser(), $poll);
            $vote->setPollOption($pollOption);
            $this->entityManager->persist($vote);
            $this->entityManager->flush();

            $globalVotes = $this->pollVoteRepository->findByPoll($poll);

            return $this->json([
                'code' => 200,
                'message' => 'Votre réponse a bien été modifiée',
                // 'prénom' => $this->getUser()->getFirstname(),
                // 'nom' => $this->getUser()->getLastname(),
                // 'email' => $this->getUser()->getEmail(),
                'pollID' => $data['votePoll'],
                'optionID' => $data['voteOptionId'],
                'totalVotes' => $globalVotes
            ]);
        }
    }

    /**
     * @Route("send-answer-contest", name="send_answer_contest")
     */
    public function send_answer_contest(Request $request): Response
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $email = $data['email'];
        $telephone = $data['telephone'];
        $option = $this->contestOptionRepository->findById(intval($data['contestOption']));
        $question = $this->contestQuestionRepository->findById(intval($data['contestQuestion']));

        $isAnswered = $this->contestEntryRepository->findByQuestionAndEmail($question, $email);

        if (!$isAnswered) {
            $entry = new ContestEntry;

            $entry
                ->setFirstname($firstname)
                ->setLastname($lastname)
                ->setEmail($email)
                ->setTelephone($telephone)
                ->setContestOption($option)
                ->setContestQuestion($question);

            $this->entityManager->persist($entry);
            $this->entityManager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Votre réponse a bien été envoyée.',
            ]);
        }
        else {
            $entry = $isAnswered;
            $entry->setContestOption($option);

            $this->entityManager->persist($entry);
            $this->entityManager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Votre réponse a bien été modifiée',
            ]);
        }
    }

    /**
     * @Route("/config-json", name="config_json")
     */
    public function config_json(): Response
    {
        $config = $this->generalConfigurationRepository->findLast();
        $event = $config->getEvent();

        return $this->json([
            'event' => $event->getActive(),
            'public' => $event->getPublic(),
        ]);
    }
}
