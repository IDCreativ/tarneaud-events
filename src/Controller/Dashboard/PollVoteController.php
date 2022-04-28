<?php

namespace App\Controller\Dashboard;

use App\Entity\PollVote;
use App\Form\PollVoteType;
use App\Repository\PollVoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/poll-vote")
 */
class PollVoteController extends AbstractController
{
    /**
     * @Route("/", name="poll_vote_index", methods={"GET"})
     */
    public function index(PollVoteRepository $pollVoteRepository): Response
    {
        return $this->render('dashboard/poll_vote/index.html.twig', [
            'poll_votes' => $pollVoteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="poll_vote_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $pollVote = new PollVote();
        $form = $this->createForm(PollVoteType::class, $pollVote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pollVote);
            $entityManager->flush();

            return $this->redirectToRoute('poll_vote_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/poll_vote/new.html.twig', [
            'poll_vote' => $pollVote,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="poll_vote_show", methods={"GET"})
     */
    public function show(PollVote $pollVote): Response
    {
        return $this->render('dashboard/poll_vote/show.html.twig', [
            'poll_vote' => $pollVote,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="poll_vote_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PollVote $pollVote): Response
    {
        $form = $this->createForm(PollVoteType::class, $pollVote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('poll_vote_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/poll_vote/edit.html.twig', [
            'poll_vote' => $pollVote,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="poll_vote_delete", methods={"POST"})
     */
    public function delete(Request $request, PollVote $pollVote): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pollVote->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pollVote);
            $entityManager->flush();
        }

        return $this->redirectToRoute('poll_vote_index', [], Response::HTTP_SEE_OTHER);
    }
}
