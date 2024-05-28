<?php

namespace App\Controller;

use App\Entity\CarteMere;
use App\Form\CarteMereType;
use App\Service\FileUploader;
use App\Repository\CarteMereRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/carte/mere')]
#[IsGranted('ROLE_ADMIN')]
class CarteMereController extends AbstractController
{
    #[Route('/', name: 'app_carte_mere_index', methods: ['GET'])]
    public function index(CarteMereRepository $carteMereRepository): Response
    {
        return $this->render('carte_mere/index.html.twig', [
            'carte_meres' => $carteMereRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_carte_mere_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CarteMereRepository $carteMereRepository, FileUploader $fileUploader): Response
    {
        $carteMere = new CarteMere();
        $form = $this->createForm(CarteMereType::class, $carteMere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère le fichier présent dans le formulaire
            $picture = $form->get('photo')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $carteMere->setPhoto($fileName);
            }
            $carteMereRepository->save($carteMere, true);

            return $this->redirectToRoute('app_carte_mere_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('carte_mere/new.html.twig', [
            'carte_mere' => $carteMere,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_carte_mere_show', methods: ['GET'])]
    public function show(CarteMere $carteMere): Response
    {
        return $this->render('carte_mere/show.html.twig', [
            'carte_mere' => $carteMere,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_carte_mere_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CarteMere $carteMere, CarteMereRepository $carteMereRepository, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(CarteMereType::class, $carteMere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère le fichier présent dans le formulaire
            $picture = $form->get('photo')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $carteMere->setPhoto($fileName);
            }
            $carteMereRepository->save($carteMere, true);

            return $this->redirectToRoute('app_carte_mere_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('carte_mere/edit.html.twig', [
            'carte_mere' => $carteMere,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_carte_mere_delete', methods: ['POST'])]
    public function delete(Request $request, CarteMere $carteMere, CarteMereRepository $carteMereRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carteMere->getId(), $request->request->get('_token'))) {
            $carteMereRepository->remove($carteMere, true);
        }

        return $this->redirectToRoute('app_carte_mere_index', [], Response::HTTP_SEE_OTHER);
    }
}
