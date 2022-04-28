<?php

namespace App\Controller\Dashboard;

use App\Entity\ContestOption;
use App\Form\ContestOptionType;
use App\Repository\ContestOptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/contest-option")
 */
class ContestOptionController extends AbstractController
{
    /**
     * @Route("/", name="contest_option_index", methods={"GET"})
     */
    public function index(ContestOptionRepository $contestOptionRepository): Response
    {
        return $this->render('dashboard/contest_option/index.html.twig', [
            'contest_options' => $contestOptionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="contest_option_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contestOption = new ContestOption();
        $form = $this->createForm(ContestOptionType::class, $contestOption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contestOption);
            $entityManager->flush();

            return $this->redirectToRoute('contest_option_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/contest_option/new.html.twig', [
            'contest_option' => $contestOption,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="contest_option_show", methods={"GET"})
     */
    public function show(ContestOption $contestOption): Response
    {
        return $this->render('dashboard/contest_option/show.html.twig', [
            'contest_option' => $contestOption,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="contest_option_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ContestOption $contestOption, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContestOptionType::class, $contestOption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('contest_option_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/contest_option/edit.html.twig', [
            'contest_option' => $contestOption,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="contest_option_delete", methods={"POST"})
     */
    public function delete(Request $request, ContestOption $contestOption, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contestOption->getId(), $request->request->get('_token'))) {
            $entityManager->remove($contestOption);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contest_option_index', [], Response::HTTP_SEE_OTHER);
    }
}
