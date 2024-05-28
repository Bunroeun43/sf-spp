<?php

namespace App\Controller;

use App\Entity\FormatAlimentation;
use App\Form\FormatAlimentationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FormatAlimentationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/format/alimentation')]
#[IsGranted('ROLE_ADMIN')]
class FormatAlimentationController extends AbstractController
{
    #[Route('/', name: 'app_format_alimentation_index', methods: ['GET'])]
    public function index(FormatAlimentationRepository $formatAlimentationRepository): Response
    {
        return $this->render('format_alimentation/index.html.twig', [
            'format_alimentations' => $formatAlimentationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_format_alimentation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FormatAlimentationRepository $formatAlimentationRepository): Response
    {
        $formatAlimentation = new FormatAlimentation();
        $form = $this->createForm(FormatAlimentationType::class, $formatAlimentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formatAlimentationRepository->save($formatAlimentation, true);

            return $this->redirectToRoute('app_format_alimentation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('format_alimentation/new.html.twig', [
            'format_alimentation' => $formatAlimentation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_format_alimentation_show', methods: ['GET'])]
    public function show(FormatAlimentation $formatAlimentation): Response
    {
        return $this->render('format_alimentation/show.html.twig', [
            'format_alimentation' => $formatAlimentation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_format_alimentation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FormatAlimentation $formatAlimentation, FormatAlimentationRepository $formatAlimentationRepository): Response
    {
        $form = $this->createForm(FormatAlimentationType::class, $formatAlimentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formatAlimentationRepository->save($formatAlimentation, true);

            return $this->redirectToRoute('app_format_alimentation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('format_alimentation/edit.html.twig', [
            'format_alimentation' => $formatAlimentation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_format_alimentation_delete', methods: ['POST'])]
    public function delete(Request $request, FormatAlimentation $formatAlimentation, FormatAlimentationRepository $formatAlimentationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formatAlimentation->getId(), $request->request->get('_token'))) {
            $formatAlimentationRepository->remove($formatAlimentation, true);
        }

        return $this->redirectToRoute('app_format_alimentation_index', [], Response::HTTP_SEE_OTHER);
    }
}
