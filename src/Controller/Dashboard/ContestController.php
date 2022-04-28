<?php

namespace App\Controller\Dashboard;

use App\Entity\Contest;
use App\Form\ContestType;
use App\Repository\ContestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/contest")
 */
class ContestController extends AbstractController
{
    /**
     * @Route("/", name="contest_index", methods={"GET"})
     */
    public function index(ContestRepository $contestRepository): Response
    {
        return $this->render('dashboard/contest/index.html.twig', [
            'contests' => $contestRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="contest_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contest = new Contest();
        $form = $this->createForm(ContestType::class, $contest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contest);
            $entityManager->flush();

            return $this->redirectToRoute('contest_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/contest/new.html.twig', [
            'contest' => $contest,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="contest_show", methods={"GET"})
     */
    public function show(Contest $contest): Response
    {
        return $this->render('dashboard/contest/show.html.twig', [
            'contest' => $contest,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="contest_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Contest $contest, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContestType::class, $contest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('contest_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/contest/edit.html.twig', [
            'contest' => $contest,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="contest_delete", methods={"POST"})
     */
    public function delete(Request $request, Contest $contest, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contest->getId(), $request->request->get('_token'))) {
            $entityManager->remove($contest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contest_index', [], Response::HTTP_SEE_OTHER);
    }
}
