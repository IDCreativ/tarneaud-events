<?php

namespace App\Controller\Dashboard;

use App\Entity\EventDate;
use App\Form\EventDateType;
use App\Repository\EventDateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/event-date")
 */
class EventDateController extends AbstractController
{
    /**
     * @Route("/", name="event_date_index", methods={"GET"})
     */
    public function index(EventDateRepository $eventDateRepository): Response
    {
        return $this->render('dashboard/event_date/index.html.twig', [
            'event_dates' => $eventDateRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="event_date_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $eventDate = new EventDate();
        $form = $this->createForm(EventDateType::class, $eventDate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($eventDate);
            $entityManager->flush();

            return $this->redirectToRoute('event_date_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/event_date/new.html.twig', [
            'event_date' => $eventDate,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="event_date_show", methods={"GET"})
     */
    public function show(EventDate $eventDate): Response
    {
        return $this->render('dashboard/event_date/show.html.twig', [
            'event_date' => $eventDate,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="event_date_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, EventDate $eventDate, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventDateType::class, $eventDate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('event_date_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/event_date/edit.html.twig', [
            'event_date' => $eventDate,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="event_date_delete", methods={"POST"})
     */
    public function delete(Request $request, EventDate $eventDate, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventDate->getId(), $request->request->get('_token'))) {
            $entityManager->remove($eventDate);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_date_index', [], Response::HTTP_SEE_OTHER);
    }
}
