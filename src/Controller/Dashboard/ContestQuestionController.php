<?php

namespace App\Controller\Dashboard;

use App\Entity\ContestQuestion;
use App\Form\ContestQuestionType;
use App\Repository\ContestQuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/contest-question")
 */
class ContestQuestionController extends AbstractController
{
    private $contestQuestionRepository;

    public function __construct(ContestQuestionRepository $contestQuestionRepository)
    {
        $this->contestQuestionRepository = $contestQuestionRepository;
    }

    /**
     * @Route("/", name="contest_question_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('dashboard/contest_question/index.html.twig', [
            'contest_questions' => $this->contestQuestionRepository->findAll()
        ]);
    }

    /**
     * @Route("/new", name="contest_question_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contestQuestion = new ContestQuestion();
        $form = $this->createForm(ContestQuestionType::class, $contestQuestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contestQuestion);
            $entityManager->flush();

            return $this->redirectToRoute('contest_question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/contest_question/new.html.twig', [
            'contest_question' => $contestQuestion,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="contest_question_show", methods={"GET"})
     */
    public function show(ContestQuestion $contestQuestion): Response
    {
        return $this->render('dashboard/contest_question/show.html.twig', [
            'contest_question' => $contestQuestion
        ]);
    }

    /**
     * @Route("/{id}/edit", name="contest_question_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ContestQuestion $contestQuestion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContestQuestionType::class, $contestQuestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('contest_question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/contest_question/edit.html.twig', [
            'contest_question' => $contestQuestion,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="contest_question_delete", methods={"POST"})
     */
    public function delete(Request $request, ContestQuestion $contestQuestion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contestQuestion->getId(), $request->request->get('_token'))) {
            $entityManager->remove($contestQuestion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contest_question_index', [], Response::HTTP_SEE_OTHER);
    }
}
