<?php

namespace App\Controller;

use App\Entity\DisqueM2;
use App\Form\DisqueM2Type;
use App\Service\FileUploader;
use App\Repository\DisqueM2Repository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/disque/m2')]
#[IsGranted('ROLE_ADMIN')]
class DisqueM2Controller extends AbstractController
{
    #[Route('/', name: 'app_disque_m2_index', methods: ['GET'])]
    public function index(DisqueM2Repository $disqueM2Repository): Response
    {
        return $this->render('disque_m2/index.html.twig', [
            'disque_m2s' => $disqueM2Repository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_disque_m2_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DisqueM2Repository $disqueM2Repository, FileUploader $fileUploader): Response
    {
        $disqueM2 = new DisqueM2();
        $form = $this->createForm(DisqueM2Type::class, $disqueM2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère le fichier présent dans le formulaire
            $picture = $form->get('photo')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $disqueM2->setPhoto($fileName);
            }
            $disqueM2Repository->save($disqueM2, true);

            return $this->redirectToRoute('app_disque_m2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('disque_m2/new.html.twig', [
            'disque_m2' => $disqueM2,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_disque_m2_show', methods: ['GET'])]
    public function show(DisqueM2 $disqueM2): Response
    {
        return $this->render('disque_m2/show.html.twig', [
            'disque_m2' => $disqueM2,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_disque_m2_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DisqueM2 $disqueM2, DisqueM2Repository $disqueM2Repository, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(DisqueM2Type::class, $disqueM2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère le fichier présent dans le formulaire
            $picture = $form->get('photo')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $disqueM2->setPhoto($fileName);
            }
            $disqueM2Repository->save($disqueM2, true);

            return $this->redirectToRoute('app_disque_m2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('disque_m2/edit.html.twig', [
            'disque_m2' => $disqueM2,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_disque_m2_delete', methods: ['POST'])]
    public function delete(Request $request, DisqueM2 $disqueM2, DisqueM2Repository $disqueM2Repository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$disqueM2->getId(), $request->request->get('_token'))) {
            $disqueM2Repository->remove($disqueM2, true);
        }

        return $this->redirectToRoute('app_disque_m2_index', [], Response::HTTP_SEE_OTHER);
    }
}
