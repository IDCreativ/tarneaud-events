<?php

namespace App\Controller\Dashboard;

use App\Entity\GeneralConfiguration;
use App\Form\GeneralConfigurationType;
use App\Repository\GeneralConfigurationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/general-configuration")
 */
class GeneralConfigurationController extends AbstractController
{
    /**
     * @Route("/", name="general_configuration_index", methods={"GET"})
     */
    public function index(GeneralConfigurationRepository $generalConfigurationRepository): Response
    {
        $config = $generalConfigurationRepository->findLast();
        return $this->redirectToRoute('general_configuration_show', [
            'id' => $config->getId()
        ]);
    }

    /**
     * @Route("/new", name="general_configuration_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $generalConfiguration = new GeneralConfiguration;
        $form = $this->createForm(GeneralConfigurationType::class, $generalConfiguration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($generalConfiguration);
            $entityManager->flush();

            return $this->redirectToRoute('dashboard', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/general_configuration/new.html.twig', [
            'general_configuration' => $generalConfiguration,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="general_configuration_show", methods={"GET"})
     */
    public function show(GeneralConfiguration $generalConfiguration): Response
    {
        return $this->render('dashboard/general_configuration/show.html.twig', [
            'general_configuration' => $generalConfiguration,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="general_configuration_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, GeneralConfiguration $generalConfiguration): Response
    {
        $form = $this->createForm(GeneralConfigurationType::class, $generalConfiguration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('general_configuration_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/general_configuration/edit.html.twig', [
            'general_configuration' => $generalConfiguration,
            'form' => $form,
        ]);
    }
}
