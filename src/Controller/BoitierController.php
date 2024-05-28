<?php

namespace App\Controller;

use App\Entity\Boitier;
use App\Form\BoitierType;
use App\Service\FileUploader;
use App\Repository\BoitierRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/boitier')]
#[IsGranted('ROLE_ADMIN')]
class BoitierController extends AbstractController
{
    #[Route('/', name: 'app_boitier_index', methods: ['GET'])]
    public function index(BoitierRepository $boitierRepository): Response
    {
        return $this->render('boitier/index.html.twig', [
            'boitiers' => $boitierRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_boitier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BoitierRepository $boitierRepository, FileUploader $fileUploader): Response
    {
        $boitier = new Boitier();
        $form = $this->createForm(BoitierType::class, $boitier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère le fichier présent dans le formulaire
            $picture = $form->get('photo')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $boitier->setPhoto($fileName);
            }
            $boitierRepository->save($boitier, true);

            return $this->redirectToRoute('app_boitier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('boitier/new.html.twig', [
            'boitier' => $boitier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_boitier_show', methods: ['GET'])]
    public function show(Boitier $boitier): Response
    {
        return $this->render('boitier/show.html.twig', [
            'boitier' => $boitier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_boitier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Boitier $boitier, BoitierRepository $boitierRepository, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(BoitierType::class, $boitier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère le fichier présent dans le formulaire
            $picture = $form->get('photo')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $boitier->setPhoto($fileName);
            }
            $boitierRepository->save($boitier, true);

            return $this->redirectToRoute('app_boitier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('boitier/edit.html.twig', [
            'boitier' => $boitier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_boitier_delete', methods: ['POST'])]
    public function delete(Request $request, Boitier $boitier, BoitierRepository $boitierRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$boitier->getId(), $request->request->get('_token'))) {
            $boitierRepository->remove($boitier, true);
        }

        return $this->redirectToRoute('app_boitier_index', [], Response::HTTP_SEE_OTHER);
    }
}
