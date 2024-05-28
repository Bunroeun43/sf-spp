<?php

namespace App\Controller;

use App\Entity\Montage;
use App\Form\MontageType;
use App\Repository\MontageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/montage')]
class MontageController extends AbstractController
{
    #[Route('/', name: 'app_montage_index', methods: ['GET'])]
    public function index(MontageRepository $montageRepository): Response
    {
        return $this->render('montage/index.html.twig', [
            'montages' => $montageRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_montage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MontageRepository $montageRepository): Response
    {
        $montage = new Montage();
        $form = $this->createForm(MontageType::class, $montage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $montageRepository->save($montage, true);

            return $this->redirectToRoute('app_montage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('montage/new.html.twig', [
            'montage' => $montage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_montage_show', methods: ['GET'])]
    public function show(Montage $montage): Response
    {
        return $this->render('montage/show.html.twig', [
            'montage' => $montage,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_montage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Montage $montage, MontageRepository $montageRepository): Response
    {
        $form = $this->createForm(MontageType::class, $montage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $montageRepository->save($montage, true);

            return $this->redirectToRoute('app_montage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('montage/edit.html.twig', [
            'montage' => $montage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_montage_delete', methods: ['POST'])]
    public function delete(Request $request, Montage $montage, MontageRepository $montageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$montage->getId(), $request->request->get('_token'))) {
            $montageRepository->remove($montage, true);
        }

        return $this->redirectToRoute('app_montage_index', [], Response::HTTP_SEE_OTHER);
    }
}
