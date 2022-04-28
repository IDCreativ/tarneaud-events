<?php

namespace App\Controller\Dashboard;

use App\Entity\Periode;
use App\Form\PeriodeType;
use App\Repository\PeriodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/periode")
 */
class PeriodeController extends AbstractController
{
    /**
     * @Route("/", name="periode_index", methods={"GET"})
     */
    public function index(PeriodeRepository $periodeRepository): Response
    {
        return $this->render('dashboard/periode/index.html.twig', [
            'periodes' => $periodeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="periode_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $periode = new Periode();
        $form = $this->createForm(PeriodeType::class, $periode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($periode);
            $entityManager->flush();

            return $this->redirectToRoute('periode_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/periode/new.html.twig', [
            'periode' => $periode,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="periode_show", methods={"GET"})
     */
    public function show(Periode $periode): Response
    {
        return $this->render('dashboard/periode/show.html.twig', [
            'periode' => $periode,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="periode_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Periode $periode): Response
    {
        $form = $this->createForm(PeriodeType::class, $periode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('periode_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/periode/edit.html.twig', [
            'periode' => $periode,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="periode_delete", methods={"POST"})
     */
    public function delete(Request $request, Periode $periode): Response
    {
        if ($this->isCsrfTokenValid('delete'.$periode->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($periode);
            $entityManager->flush();
        }

        return $this->redirectToRoute('periode_index', [], Response::HTTP_SEE_OTHER);
    }
}
