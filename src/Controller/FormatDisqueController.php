<?php

namespace App\Controller;

use App\Entity\FormatDisque;
use App\Form\FormatDisqueType;
use App\Repository\FormatDisqueRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/format/disque')]
#[IsGranted('ROLE_ADMIN')]
class FormatDisqueController extends AbstractController
{
    #[Route('/', name: 'app_format_disque_index', methods: ['GET'])]
    public function index(FormatDisqueRepository $formatDisqueRepository): Response
    {
        return $this->render('format_disque/index.html.twig', [
            'format_disques' => $formatDisqueRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_format_disque_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FormatDisqueRepository $formatDisqueRepository): Response
    {
        $formatDisque = new FormatDisque();
        $form = $this->createForm(FormatDisqueType::class, $formatDisque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formatDisqueRepository->save($formatDisque, true);

            return $this->redirectToRoute('app_format_disque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('format_disque/new.html.twig', [
            'format_disque' => $formatDisque,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_format_disque_show', methods: ['GET'])]
    public function show(FormatDisque $formatDisque): Response
    {
        return $this->render('format_disque/show.html.twig', [
            'format_disque' => $formatDisque,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_format_disque_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FormatDisque $formatDisque, FormatDisqueRepository $formatDisqueRepository): Response
    {
        $form = $this->createForm(FormatDisqueType::class, $formatDisque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formatDisqueRepository->save($formatDisque, true);

            return $this->redirectToRoute('app_format_disque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('format_disque/edit.html.twig', [
            'format_disque' => $formatDisque,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_format_disque_delete', methods: ['POST'])]
    public function delete(Request $request, FormatDisque $formatDisque, FormatDisqueRepository $formatDisqueRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formatDisque->getId(), $request->request->get('_token'))) {
            $formatDisqueRepository->remove($formatDisque, true);
        }

        return $this->redirectToRoute('app_format_disque_index', [], Response::HTTP_SEE_OTHER);
    }
}
