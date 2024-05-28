<?php

namespace App\Controller;

use App\Entity\FormatCarteMere;
use App\Form\FormatCarteMereType;
use App\Repository\FormatCarteMereRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/format/carte/mere')]
#[IsGranted('ROLE_ADMIN')]
class FormatCarteMereController extends AbstractController
{
    #[Route('/', name: 'app_format_carte_mere_index', methods: ['GET'])]
    public function index(FormatCarteMereRepository $formatCarteMereRepository): Response
    {
        return $this->render('format_carte_mere/index.html.twig', [
            'format_carte_meres' => $formatCarteMereRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_format_carte_mere_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FormatCarteMereRepository $formatCarteMereRepository): Response
    {
        $formatCarteMere = new FormatCarteMere();
        $form = $this->createForm(FormatCarteMereType::class, $formatCarteMere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formatCarteMereRepository->save($formatCarteMere, true);

            return $this->redirectToRoute('app_format_carte_mere_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('format_carte_mere/new.html.twig', [
            'format_carte_mere' => $formatCarteMere,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_format_carte_mere_show', methods: ['GET'])]
    public function show(FormatCarteMere $formatCarteMere): Response
    {
        return $this->render('format_carte_mere/show.html.twig', [
            'format_carte_mere' => $formatCarteMere,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_format_carte_mere_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FormatCarteMere $formatCarteMere, FormatCarteMereRepository $formatCarteMereRepository): Response
    {
        $form = $this->createForm(FormatCarteMereType::class, $formatCarteMere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formatCarteMereRepository->save($formatCarteMere, true);

            return $this->redirectToRoute('app_format_carte_mere_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('format_carte_mere/edit.html.twig', [
            'format_carte_mere' => $formatCarteMere,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_format_carte_mere_delete', methods: ['POST'])]
    public function delete(Request $request, FormatCarteMere $formatCarteMere, FormatCarteMereRepository $formatCarteMereRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formatCarteMere->getId(), $request->request->get('_token'))) {
            $formatCarteMereRepository->remove($formatCarteMere, true);
        }

        return $this->redirectToRoute('app_format_carte_mere_index', [], Response::HTTP_SEE_OTHER);
    }
}
