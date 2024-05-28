<?php

namespace App\Controller;

use App\Service\FileUploader;
use App\Entity\CarteGraphique;
use App\Form\CarteGraphiqueType;
use App\Repository\CarteGraphiqueRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/carte/graphique')]
#[IsGranted('ROLE_ADMIN')]
class CarteGraphiqueController extends AbstractController
{
    #[Route('/', name: 'app_carte_graphique_index', methods: ['GET'])]
    public function index(CarteGraphiqueRepository $carteGraphiqueRepository): Response
    {
        return $this->render('carte_graphique/index.html.twig', [
            'carte_graphiques' => $carteGraphiqueRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_carte_graphique_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CarteGraphiqueRepository $carteGraphiqueRepository, FileUploader $fileUploader): Response
    {
        $carteGraphique = new CarteGraphique();
        $form = $this->createForm(CarteGraphiqueType::class, $carteGraphique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère le fichier présent dans le formulaire
            $picture = $form->get('photo')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $carteGraphique->setPhoto($fileName);
            }
            $carteGraphiqueRepository->save($carteGraphique, true);

            return $this->redirectToRoute('app_carte_graphique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('carte_graphique/new.html.twig', [
            'carte_graphique' => $carteGraphique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_carte_graphique_show', methods: ['GET'])]
    public function show(CarteGraphique $carteGraphique): Response
    {
        return $this->render('carte_graphique/show.html.twig', [
            'carte_graphique' => $carteGraphique,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_carte_graphique_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CarteGraphique $carteGraphique, CarteGraphiqueRepository $carteGraphiqueRepository, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(CarteGraphiqueType::class, $carteGraphique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère le fichier présent dans le formulaire
            $picture = $form->get('photo')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $carteGraphique->setPhoto($fileName);
            }
            $carteGraphiqueRepository->save($carteGraphique, true);

            return $this->redirectToRoute('app_carte_graphique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('carte_graphique/edit.html.twig', [
            'carte_graphique' => $carteGraphique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_carte_graphique_delete', methods: ['POST'])]
    public function delete(Request $request, CarteGraphique $carteGraphique, CarteGraphiqueRepository $carteGraphiqueRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carteGraphique->getId(), $request->request->get('_token'))) {
            $carteGraphiqueRepository->remove($carteGraphique, true);
        }

        return $this->redirectToRoute('app_carte_graphique_index', [], Response::HTTP_SEE_OTHER);
    }
}
