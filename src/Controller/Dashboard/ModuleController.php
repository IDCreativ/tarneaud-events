<?php

namespace App\Controller\Dashboard;

use App\Entity\Module;
use App\Form\ModuleType;
use App\Repository\ModuleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/dashboard/module")
 */
class ModuleController extends AbstractController
{
    /**
     * @Route("/", name="module_index", methods={"GET"})
     */
    public function index(ModuleRepository $moduleRepository): Response
    {
        return $this->render('dashboard/module/index.html.twig', [
            'modules' => $moduleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="module_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $module = new Module();
        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($module);
            $entityManager->flush();

            return $this->redirectToRoute('module_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/module/new.html.twig', [
            'module' => $module,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="module_show", methods={"GET"})
     */
    public function show(Module $module): Response
    {
        return $this->render('dashboard/module/show.html.twig', [
            'module' => $module,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="module_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Module $module, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('module_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/module/edit.html.twig', [
            'module' => $module,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="module_delete", methods={"POST"})
     */
    public function delete(Request $request, Module $module, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$module->getId(), $request->request->get('_token'))) {
            $entityManager->remove($module);
            $entityManager->flush();
        }

        return $this->redirectToRoute('module_index', [], Response::HTTP_SEE_OTHER);
    }
}
