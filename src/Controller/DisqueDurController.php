<?php

namespace App\Controller;

use App\Entity\DisqueDur;
use App\Form\DisqueDurType;
use App\Service\FileUploader;
use App\Repository\DisqueDurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/disque/dur')]
#[IsGranted('ROLE_ADMIN')]
class DisqueDurController extends AbstractController
{
    #[Route('/', name: 'app_disque_dur_index', methods: ['GET'])]
    public function index(DisqueDurRepository $disqueDurRepository): Response
    {
        return $this->render('disque_dur/index.html.twig', [
            'disque_durs' => $disqueDurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_disque_dur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DisqueDurRepository $disqueDurRepository, FileUploader $fileUploader): Response
    {
        $disqueDur = new DisqueDur();
        $form = $this->createForm(DisqueDurType::class, $disqueDur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère le fichier présent dans le formulaire
            $picture = $form->get('photo')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $disqueDur->setPhoto($fileName);
            }
            $disqueDurRepository->save($disqueDur, true);

            return $this->redirectToRoute('app_disque_dur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('disque_dur/new.html.twig', [
            'disque_dur' => $disqueDur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_disque_dur_show', methods: ['GET'])]
    public function show(DisqueDur $disqueDur): Response
    {
        return $this->render('disque_dur/show.html.twig', [
            'disque_dur' => $disqueDur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_disque_dur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DisqueDur $disqueDur, DisqueDurRepository $disqueDurRepository, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(DisqueDurType::class, $disqueDur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère le fichier présent dans le formulaire
            $picture = $form->get('photo')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $disqueDur->setPhoto($fileName);
            }
            $disqueDurRepository->save($disqueDur, true);

            return $this->redirectToRoute('app_disque_dur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('disque_dur/edit.html.twig', [
            'disque_dur' => $disqueDur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_disque_dur_delete', methods: ['POST'])]
    public function delete(Request $request, DisqueDur $disqueDur, DisqueDurRepository $disqueDurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$disqueDur->getId(), $request->request->get('_token'))) {
            $disqueDurRepository->remove($disqueDur, true);
        }

        return $this->redirectToRoute('app_disque_dur_index', [], Response::HTTP_SEE_OTHER);
    }
}
