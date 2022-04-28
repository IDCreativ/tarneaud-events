<?php

namespace App\Controller\Dashboard;

use App\Repository\EventRepository;
use App\Repository\VideoRepository;
use App\Entity\GeneralConfiguration;
use App\Repository\ModuleRepository;
use App\Repository\CategoryRepository;
use App\Repository\ContestRepository;
use App\Repository\PartnersRepository;
use App\Repository\QuestionRepository;
use App\Repository\ProgrammeRepository;
use App\Repository\PageConfigRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\GeneralConfigurationRepository;
use App\Repository\PollRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/dashboard")
 */
class DashboardController extends AbstractController
{
    private $videoRepository;
    private $questionRepository;
    private $generalConfigurationRepository;
    private $categoryRepository;
    private $eventRepository;
    private $partnersRepository;
    private $programmeRepository;
    private $moduleRepository;
    private $pollRepository;
    private $contestRepository;

    public function __construct(
        GeneralConfigurationRepository $generalConfigurationRepository,
        VideoRepository $videoRepository,
        QuestionRepository $questionRepository,
        CategoryRepository $categoryRepository,
        PartnersRepository $partnersRepository,
        EventRepository $eventRepository,
        ProgrammeRepository $programmeRepository,
        ModuleRepository $moduleRepository,
        PollRepository $pollRepository,
        ContestRepository $contestRepository
    )
    {
        $this->generalConfigurationRepository = $generalConfigurationRepository;
        $this->videoRepository = $videoRepository;
        $this->questionRepository = $questionRepository;
        $this->categoryRepository = $categoryRepository;
        $this->eventRepository = $eventRepository;
        $this->partnersRepository = $partnersRepository;
        $this->programmeRepository = $programmeRepository;
        $this->moduleRepository = $moduleRepository;
        $this->pollRepository = $pollRepository;
        $this->contestRepository = $contestRepository;
    }

    /**
     * @Route("/", name="dashboard", methods={"GET"})
     */
    public function dashboard()
    {
        $modules = $this->moduleRepository->findBy([], ['id'=>'ASC']);
        $questions = $this->questionRepository->findBy([], ['id'=>'DESC']);
        return $this->render('dashboard/dashboard.html.twig', [
            'controller_name'   => 'Dashboard',
            'questions'         => $questions,
            'polls'             => $this->pollRepository->findAll(),
            'modules'           => $modules,
            'contests'          => $this->contestRepository->findByEvent($this->generalConfigurationRepository->findLast()->getEvent()),
        ]);
    }
}
