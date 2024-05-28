<?php

namespace App\Controller;

use App\Entity\Processeur;
use App\Form\ProcesseurType;
use App\Repository\ProcesseurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/processeur')]
#[IsGranted('ROLE_ADMIN')]
class ProcesseurController extends AbstractController
{
    #[Route('/', name: 'app_processeur_index', methods: ['GET'])]
    public function index(ProcesseurRepository $processeurRepository): Response
    {
        return $this->render('processeur/index.html.twig', [
            'processeurs' => $processeurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_processeur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProcesseurRepository $processeurRepository): Response
    {
        $processeur = new Processeur();
        $form = $this->createForm(ProcesseurType::class, $processeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $processeurRepository->save($processeur, true);

            return $this->redirectToRoute('app_processeur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('processeur/new.html.twig', [
            'processeur' => $processeur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_processeur_show', methods: ['GET'])]
    public function show(Processeur $processeur): Response
    {
        return $this->render('processeur/show.html.twig', [
            'processeur' => $processeur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_processeur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Processeur $processeur, ProcesseurRepository $processeurRepository): Response
    {
        $form = $this->createForm(ProcesseurType::class, $processeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $processeurRepository->save($processeur, true);

            return $this->redirectToRoute('app_processeur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('processeur/edit.html.twig', [
            'processeur' => $processeur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_processeur_delete', methods: ['POST'])]
    public function delete(Request $request, Processeur $processeur, ProcesseurRepository $processeurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$processeur->getId(), $request->request->get('_token'))) {
            $processeurRepository->remove($processeur, true);
        }

        return $this->redirectToRoute('app_processeur_index', [], Response::HTTP_SEE_OTHER);
    }
}
