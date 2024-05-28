<?php

namespace App\Controller;

use App\Entity\FormatBoitier;
use App\Form\FormatBoitierType;
use App\Repository\FormatBoitierRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/format/boitier')]
#[IsGranted('ROLE_ADMIN')]
class FormatBoitierController extends AbstractController
{
    #[Route('/', name: 'app_format_boitier_index', methods: ['GET'])]
    public function index(FormatBoitierRepository $formatBoitierRepository): Response
    {
        return $this->render('format_boitier/index.html.twig', [
            'format_boitiers' => $formatBoitierRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_format_boitier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FormatBoitierRepository $formatBoitierRepository): Response
    {
        $formatBoitier = new FormatBoitier();
        $form = $this->createForm(FormatBoitierType::class, $formatBoitier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formatBoitierRepository->save($formatBoitier, true);

            return $this->redirectToRoute('app_format_boitier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('format_boitier/new.html.twig', [
            'format_boitier' => $formatBoitier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_format_boitier_show', methods: ['GET'])]
    public function show(FormatBoitier $formatBoitier): Response
    {
        return $this->render('format_boitier/show.html.twig', [
            'format_boitier' => $formatBoitier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_format_boitier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FormatBoitier $formatBoitier, FormatBoitierRepository $formatBoitierRepository): Response
    {
        $form = $this->createForm(FormatBoitierType::class, $formatBoitier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formatBoitierRepository->save($formatBoitier, true);

            return $this->redirectToRoute('app_format_boitier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('format_boitier/edit.html.twig', [
            'format_boitier' => $formatBoitier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_format_boitier_delete', methods: ['POST'])]
    public function delete(Request $request, FormatBoitier $formatBoitier, FormatBoitierRepository $formatBoitierRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formatBoitier->getId(), $request->request->get('_token'))) {
            $formatBoitierRepository->remove($formatBoitier, true);
        }

        return $this->redirectToRoute('app_format_boitier_index', [], Response::HTTP_SEE_OTHER);
    }
}
