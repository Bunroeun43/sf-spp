<?php

namespace App\Controller;

use App\Entity\Memoire;
use App\Form\MemoireType;
use App\Service\FileUploader;
use App\Repository\MemoireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/memoire')]
#[IsGranted('ROLE_ADMIN')]
class MemoireController extends AbstractController
{
    #[Route('/', name: 'app_memoire_index', methods: ['GET'])]
    public function index(MemoireRepository $memoireRepository): Response
    {
        return $this->render('memoire/index.html.twig', [
            'memoires' => $memoireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_memoire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MemoireRepository $memoireRepository, FileUploader $fileUploader): Response
    {
        $memoire = new Memoire();
        $form = $this->createForm(MemoireType::class, $memoire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère le fichier présent dans le formulaire
            $picture = $form->get('photo')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $memoire->setPhoto($fileName);
            }
            $memoireRepository->save($memoire, true);

            return $this->redirectToRoute('app_memoire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('memoire/new.html.twig', [
            'memoire' => $memoire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_memoire_show', methods: ['GET'])]
    public function show(Memoire $memoire): Response
    {
        return $this->render('memoire/show.html.twig', [
            'memoire' => $memoire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_memoire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Memoire $memoire, MemoireRepository $memoireRepository, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(MemoireType::class, $memoire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère le fichier présent dans le formulaire
            $picture = $form->get('photo')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $memoire->setPhoto($fileName);
            }
            $memoireRepository->save($memoire, true);

            return $this->redirectToRoute('app_memoire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('memoire/edit.html.twig', [
            'memoire' => $memoire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_memoire_delete', methods: ['POST'])]
    public function delete(Request $request, Memoire $memoire, MemoireRepository $memoireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$memoire->getId(), $request->request->get('_token'))) {
            $memoireRepository->remove($memoire, true);
        }

        return $this->redirectToRoute('app_memoire_index', [], Response::HTTP_SEE_OTHER);
    }
}
