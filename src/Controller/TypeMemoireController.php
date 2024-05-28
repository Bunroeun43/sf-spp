<?php

namespace App\Controller;

use App\Entity\TypeMemoire;
use App\Form\TypeMemoireType;
use App\Repository\TypeMemoireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/type/memoire')]
#[IsGranted('ROLE_ADMIN')]
class TypeMemoireController extends AbstractController
{
    #[Route('/', name: 'app_type_memoire_index', methods: ['GET'])]
    public function index(TypeMemoireRepository $typeMemoireRepository): Response
    {
        return $this->render('type_memoire/index.html.twig', [
            'type_memoires' => $typeMemoireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_type_memoire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TypeMemoireRepository $typeMemoireRepository): Response
    {
        $typeMemoire = new TypeMemoire();
        $form = $this->createForm(TypeMemoireType::class, $typeMemoire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeMemoireRepository->save($typeMemoire, true);

            return $this->redirectToRoute('app_type_memoire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_memoire/new.html.twig', [
            'type_memoire' => $typeMemoire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_memoire_show', methods: ['GET'])]
    public function show(TypeMemoire $typeMemoire): Response
    {
        return $this->render('type_memoire/show.html.twig', [
            'type_memoire' => $typeMemoire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_type_memoire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeMemoire $typeMemoire, TypeMemoireRepository $typeMemoireRepository): Response
    {
        $form = $this->createForm(TypeMemoireType::class, $typeMemoire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeMemoireRepository->save($typeMemoire, true);

            return $this->redirectToRoute('app_type_memoire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_memoire/edit.html.twig', [
            'type_memoire' => $typeMemoire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_memoire_delete', methods: ['POST'])]
    public function delete(Request $request, TypeMemoire $typeMemoire, TypeMemoireRepository $typeMemoireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeMemoire->getId(), $request->request->get('_token'))) {
            $typeMemoireRepository->remove($typeMemoire, true);
        }

        return $this->redirectToRoute('app_type_memoire_index', [], Response::HTTP_SEE_OTHER);
    }
}
