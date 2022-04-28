<?php

namespace App\Controller\Dashboard;

use App\Entity\ContestEntry;
use App\Form\ContestEntryType;
use App\Repository\ContestEntryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/contest-entry")
 */
class ContestEntryController extends AbstractController
{
    /**
     * @Route("/", name="contest_entry_index", methods={"GET"})
     */
    public function index(ContestEntryRepository $contestEntryRepository): Response
    {
        return $this->render('dashboard/contest_entry/index.html.twig', [
            'contest_entries' => $contestEntryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="contest_entry_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contestEntry = new ContestEntry();
        $form = $this->createForm(ContestEntryType::class, $contestEntry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contestEntry);
            $entityManager->flush();

            return $this->redirectToRoute('contest_entry_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/contest_entry/new.html.twig', [
            'contest_entry' => $contestEntry,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="contest_entry_show", methods={"GET"})
     */
    public function show(ContestEntry $contestEntry): Response
    {
        return $this->render('dashboard/contest_entry/show.html.twig', [
            'contest_entry' => $contestEntry,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="contest_entry_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ContestEntry $contestEntry, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContestEntryType::class, $contestEntry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('contest_entry_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/contest_entry/edit.html.twig', [
            'contest_entry' => $contestEntry,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="contest_entry_delete", methods={"POST"})
     */
    public function delete(Request $request, ContestEntry $contestEntry, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contestEntry->getId(), $request->request->get('_token'))) {
            $entityManager->remove($contestEntry);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contest_entry_index', [], Response::HTTP_SEE_OTHER);
    }
}
