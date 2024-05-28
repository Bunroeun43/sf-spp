<?php

namespace App\Controller;

use App\Entity\Alimentation;
use App\Service\FileUploader;
use App\Form\AlimentationType;
use App\Repository\AlimentationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/alimentation')]
#[IsGranted('ROLE_ADMIN')]
class AlimentationController extends AbstractController
{
    #[Route('/', name: 'app_alimentation_index', methods: ['GET'])]
    public function index(AlimentationRepository $alimentationRepository): Response
    {
        return $this->render('alimentation/index.html.twig', [
            'alimentations' => $alimentationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: ' ', methods: ['GET', 'POST'])]
    public function new(Request $request, AlimentationRepository $alimentationRepository, FileUploader $fileUploader): Response
    {
        $alimentation = new Alimentation();
        $form = $this->createForm(AlimentationType::class, $alimentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère le fichier présent dans le formulaire
            $picture = $form->get('photo')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $alimentation->setPhoto($fileName);
            }
            $alimentationRepository->save($alimentation, true);

            return $this->redirectToRoute('app_alimentation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('alimentation/new.html.twig', [
            'alimentation' => $alimentation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_alimentation_show', methods: ['GET'])]
    public function show(Alimentation $alimentation): Response
    {
        return $this->render('alimentation/show.html.twig', [
            'alimentation' => $alimentation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_alimentation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Alimentation $alimentation, AlimentationRepository $alimentationRepository, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(AlimentationType::class, $alimentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère le fichier présent dans le formulaire
            $picture = $form->get('photo')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $alimentation->setPhoto($fileName);
            }
            $alimentationRepository->save($alimentation, true);

            return $this->redirectToRoute('app_alimentation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('alimentation/edit.html.twig', [
            'alimentation' => $alimentation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_alimentation_delete', methods: ['POST'])]
    public function delete(Request $request, Alimentation $alimentation, AlimentationRepository $alimentationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$alimentation->getId(), $request->request->get('_token'))) {
            $alimentationRepository->remove($alimentation, true);
        }

        return $this->redirectToRoute('app_alimentation_index', [], Response::HTTP_SEE_OTHER);
    }
}
