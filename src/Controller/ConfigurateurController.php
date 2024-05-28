<?php

namespace App\Controller;

use App\Entity\Configurateur;
use App\Form\ConfigurateurType;
use App\Repository\MontageRepository;
use App\Repository\ConfigurateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/configurateur')]
class ConfigurateurController extends AbstractController
{
    #[Route('/', name: 'app_configurateur_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(ConfigurateurRepository $configurateurRepository): Response
    {
        return $this->render('configurateur/index.html.twig', [
            'configurateurs' => $configurateurRepository->findBy(['isActive' => true]),
        ]);
    }

    #[Route('/user', name: 'app_configurateur_user_index', methods: ['GET'])]
    public function user_index(ConfigurateurRepository $configurateurRepository, MontageRepository $montageRepository): Response
    {
        return $this->render('configurateur/index.html.twig', [
            'configurateurs' => $configurateurRepository->findBy(['user'=>$this->getUser()]),
            'montages' => $montageRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_configurateur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ConfigurateurRepository $configurateurRepository): Response
    {
        $configurateur = new Configurateur();
        $configurateur->setUser($this->getUser());
        $form = $this->createForm(ConfigurateurType::class, $configurateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $configurateurRepository->save($configurateur, true);

            return $this->redirectToRoute('app_configurateur_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('configurateur/new.html.twig', [
            'configurateur' => $configurateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_configurateur_show', methods: ['GET'])]
    public function show(Configurateur $configurateur): Response
    {
        return $this->render('configurateur/show.html.twig', [
            'configurateur' => $configurateur,
        ]);
    }
    
    #[Route('/user/{id}', name: 'app_configurateur_user_show', methods: ['GET'])]
    public function Usershow(Configurateur $configurateur): Response
    {
        return $this->render('configurateur/show_devis.html.twig', [
            'configurateur' => $configurateur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_configurateur_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Configurateur $configurateur, ConfigurateurRepository $configurateurRepository): Response
    {
        $form = $this->createForm(ConfigurateurType::class, $configurateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $configurateurRepository->save($configurateur, true);

            return $this->redirectToRoute('app_configurateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('configurateur/edit.html.twig', [
            'configurateur' => $configurateur,
            'form' => $form,
        ]);
    }

    #[Route('user/{id}/edit', name: 'app_configurateur_user_edit', methods: ['GET', 'POST'])]
    public function Useredit(Request $request, Configurateur $configurateur, ConfigurateurRepository $configurateurRepository): Response
    {
        $form = $this->createForm(ConfigurateurType::class, $configurateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $configurateurRepository->save($configurateur, true);

            return $this->redirectToRoute('app_configurateur_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('configurateur/edit.html.twig', [
            'configurateur' => $configurateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_configurateur_delete', methods: ['POST'])]
    public function delete(Request $request, Configurateur $configurateur, ConfigurateurRepository $configurateurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$configurateur->getId(), $request->request->get('_token'))) {
            $configurateurRepository->remove($configurateur, true);
        }

        return $this->redirectToRoute('app_configurateur_index', [], Response::HTTP_SEE_OTHER);
    }
}
