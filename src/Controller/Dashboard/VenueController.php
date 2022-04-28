<?php

namespace App\Controller\Dashboard;

use App\Entity\Venue;
use App\Form\VenueType;
use App\Repository\VenueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/venue")
 */
class VenueController extends AbstractController
{
    /**
     * @Route("/", name="venue_index", methods={"GET"})
     */
    public function index(VenueRepository $venueRepository): Response
    {
        return $this->render('dashboard/venue/index.html.twig', [
            'venues' => $venueRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="venue_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $venue = new Venue();
        $form = $this->createForm(VenueType::class, $venue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($venue);
            $entityManager->flush();

            return $this->redirectToRoute('venue_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/venue/new.html.twig', [
            'venue' => $venue,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="venue_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Venue $venue, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VenueType::class, $venue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('venue_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/venue/edit.html.twig', [
            'venue' => $venue,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="venue_delete", methods={"POST"})
     */
    public function delete(Request $request, Venue $venue, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$venue->getId(), $request->request->get('_token'))) {
            $entityManager->remove($venue);
            $entityManager->flush();
        }

        return $this->redirectToRoute('venue_index', [], Response::HTTP_SEE_OTHER);
    }
}
