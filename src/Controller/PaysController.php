<?php

namespace App\Controller;

use App\Entity\Pays;
use App\Form\PaysType;
use App\Service\FileUploader;
use App\Repository\PaysRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/pays')]
#[IsGranted('ROLE_ADMIN')]
class PaysController extends AbstractController
{
    #[Route('/', name: 'app_pays_index', methods: ['GET'])]
    public function index(PaysRepository $paysRepository): Response
    {
        return $this->render('pays/index.html.twig', [
            'pays' => $paysRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_pays_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PaysRepository $paysRepository, FileUploader $fileUploader): Response
    {
        $pay = new Pays();
        $form = $this->createForm(PaysType::class, $pay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère le fichier présent dans le formulaire
            $picture = $form->get('photo')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $pay->setPhoto($fileName);
            }
            $paysRepository->save($pay, true);

            return $this->redirectToRoute('app_pays_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pays/new.html.twig', [
            'pay' => $pay,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pays_show', methods: ['GET'])]
    public function show(Pays $pay): Response
    {
        return $this->render('pays/show.html.twig', [
            'pay' => $pay,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pays_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pays $pay, PaysRepository $paysRepository, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(PaysType::class, $pay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère le fichier présent dans le formulaire
            $picture = $form->get('photo')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $pay->setPhoto($fileName);
            }
            $paysRepository->save($pay, true);

            return $this->redirectToRoute('app_pays_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pays/edit.html.twig', [
            'pay' => $pay,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pays_delete', methods: ['POST'])]
    public function delete(Request $request, Pays $pay, PaysRepository $paysRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pay->getId(), $request->request->get('_token'))) {
            $paysRepository->remove($pay, true);
        }

        return $this->redirectToRoute('app_pays_index', [], Response::HTTP_SEE_OTHER);
    }
}
