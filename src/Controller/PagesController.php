<?php

namespace App\Controller;

use App\Entity\Page;
use App\Entity\Feedback;
use App\Form\FeedbackType;
use App\Repository\PageRepository;
use App\Repository\PollRepository;
use App\Repository\EventRepository;
use App\Repository\VideoRepository;
use App\Repository\ModuleRepository;
use App\Repository\ContestRepository;
use App\Repository\CategoryRepository;
use App\Repository\FeedbackRepository;
use App\Repository\PartnersRepository;
use App\Repository\PollVoteRepository;
use App\Repository\QuestionRepository;
use App\Repository\ProgrammeRepository;
use App\Repository\PollOptionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\GeneralConfigurationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PagesController extends AbstractController
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
    private $contestRepository;
    private $moduleRepository;

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
        ContestRepository $contestRepository,
        ModuleRepository $moduleRepository
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
        $this->contestRepository = $contestRepository;
        $this->moduleRepository = $moduleRepository;
    }

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        // if (!$this->getUser() && $this->generalConfigurationRepository->findLast()->getEvent() != null) {
        //     $this->addFlash('info', 'Vous devez être connecté pour accéder à cette page.');
        //     return $this->redirectToRoute('app_inscription');
        // }

        return $this->render('pages/index.html.twig', [
            'controller_name'   => 'Accueil',
            'programmes'        => $this->programmeRepository->findBy(['event' => $this->generalConfigurationRepository->findLast()->getEvent()], ['dateStart' => 'asc']),
            'modulesArray'      => $this->generalConfigurationRepository->findLast() ? $this->generalConfigurationRepository->findLast()->getModules() : [],
            'polls'             => $this->pollRepository->findAll(),
            'questions'         => $this->questionRepository->findBy([], ['id' => 'asc']),
            'events'            => $this->eventRepository->findBy([], ['id' => 'desc']),
            'video'             => $this->generalConfigurationRepository->findLast() != null ? $this->videoRepository->findOneByEvent($this->generalConfigurationRepository->findLast()->getEvent()) : "",
            'replays'           => $this->videoRepository->findByType(2),
            'categories'        => $this->categoryRepository->findAll(),
            'partners'          => $this->partnersRepository->findAll(),
            'contests'          => $this->contestRepository->findByEvent($this->generalConfigurationRepository->findLast()->getEvent()),
            'moduleJeu'         => $this->moduleRepository->findOneBy(['slug' => 'jeux-concours']),
        ]);
    }

    /**
     * @Route("/feedback", name="app_feedback", methods={"GET", "POST"})
     */
    public function feedback(Request $request, FeedbackRepository $feedbackRepository): Response
    {
        $feedback = new Feedback();
        $form = $this->createForm(FeedbackType::class, $feedback);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $feedbackRepository->add($feedback);
            $this->addFlash(
                'success',
                'Votre message a bien été envoyé. Nous vous remercions pour votre retour.'
            );
            return $this->redirectToRoute('home');
        }

        return $this->renderForm('pages/feedback.html.twig', [
            'feedback' => $feedback,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/pages/{slug}", name="page_single", methods={"GET"})
     */
    public function page_single(Page $page): Response
    {
        return $this->render('/pages/pages.html.twig', [
            'page' => $page,
        ]);
    }
}
