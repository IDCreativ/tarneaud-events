<?php

namespace App\Controller\Dashboard;

use App\Entity\PollOption;
use App\Form\PollOptionType;
use App\Repository\PollOptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/poll-option")
 */
class PollOptionController extends AbstractController
{
    /**
     * @Route("/", name="poll_option_index", methods={"GET"})
     */
    public function index(PollOptionRepository $pollOptionRepository): Response
    {
        return $this->render('dashboard/poll_option/index.html.twig', [
            'poll_options' => $pollOptionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="poll_option_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $pollOption = new PollOption();
        $form = $this->createForm(PollOptionType::class, $pollOption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pollOption);
            $entityManager->flush();

            return $this->redirectToRoute('poll_option_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/poll_option/new.html.twig', [
            'poll_option' => $pollOption,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="poll_option_show", methods={"GET"})
     */
    public function show(PollOption $pollOption): Response
    {
        return $this->render('dashboard/poll_option/show.html.twig', [
            'poll_option' => $pollOption,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="poll_option_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PollOption $pollOption): Response
    {
        $form = $this->createForm(PollOptionType::class, $pollOption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('poll_option_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/poll_option/edit.html.twig', [
            'poll_option' => $pollOption,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="poll_option_delete", methods={"POST"})
     */
    public function delete(Request $request, PollOption $pollOption): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pollOption->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pollOption);
            $entityManager->flush();
        }

        return $this->redirectToRoute('poll_option_index', [], Response::HTTP_SEE_OTHER);
    }
}
