<?php

namespace App\Controller;

use App\Entity\DisqueSsd;
use App\Form\DisqueSsdType;
use App\Service\FileUploader;
use App\Repository\DisqueSsdRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/disque/ssd')]
#[IsGranted('ROLE_ADMIN')]
class DisqueSsdController extends AbstractController
{
    #[Route('/', name: 'app_disque_ssd_index', methods: ['GET'])]
    public function index(DisqueSsdRepository $disqueSsdRepository): Response
    {
        return $this->render('disque_ssd/index.html.twig', [
            'disque_ssds' => $disqueSsdRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_disque_ssd_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DisqueSsdRepository $disqueSsdRepository, FileUploader $fileUploader): Response
    {
        $disqueSsd = new DisqueSsd();
        $form = $this->createForm(DisqueSsdType::class, $disqueSsd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère le fichier présent dans le formulaire
            $picture = $form->get('photo')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $disqueSsd->setPhoto($fileName);
            }
            $disqueSsdRepository->save($disqueSsd, true);

            return $this->redirectToRoute('app_disque_ssd_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('disque_ssd/new.html.twig', [
            'disque_ssd' => $disqueSsd,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_disque_ssd_show', methods: ['GET'])]
    public function show(DisqueSsd $disqueSsd): Response
    {
        return $this->render('disque_ssd/show.html.twig', [
            'disque_ssd' => $disqueSsd,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_disque_ssd_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DisqueSsd $disqueSsd, DisqueSsdRepository $disqueSsdRepository, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(DisqueSsdType::class, $disqueSsd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère le fichier présent dans le formulaire
            $picture = $form->get('photo')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $disqueSsd->setPhoto($fileName);
            }
            $disqueSsdRepository->save($disqueSsd, true);

            return $this->redirectToRoute('app_disque_ssd_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('disque_ssd/edit.html.twig', [
            'disque_ssd' => $disqueSsd,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_disque_ssd_delete', methods: ['POST'])]
    public function delete(Request $request, DisqueSsd $disqueSsd, DisqueSsdRepository $disqueSsdRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$disqueSsd->getId(), $request->request->get('_token'))) {
            $disqueSsdRepository->remove($disqueSsd, true);
        }

        return $this->redirectToRoute('app_disque_ssd_index', [], Response::HTTP_SEE_OTHER);
    }
}
