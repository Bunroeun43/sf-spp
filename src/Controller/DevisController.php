<?php

namespace App\Controller;

use App\Entity\Montage;
use App\Entity\Societe;
use App\Form\BoitierType;
use App\Entity\Configurateur;
use App\Form\ConfigurateurType;
use App\Repository\MontageRepository;
use App\Repository\ConfigurateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ConfigurateurValiderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DevisController extends AbstractController
{
    #[Route('/devis', name: 'app_devis', methods: ['GET'])]
    public function index(ConfigurateurRepository $configurateurRepository, MontageRepository $montageRepository): Response
    {
        return $this->render('devis/index.html.twig', [
            'configurateurs' => $configurateurRepository->findBy(['user'=>$this->getUser()]),
            'controller_name' => 'DevisController',
            'montages' => $montageRepository->findAll(),
        ]);
    }

    #[Route('/{id}/show', name: 'app_devis_show', methods: ['GET', 'POST'])]
    public function show(Configurateur $configurateur, ConfigurateurValiderRepository $configurateurValiderRepository): Response
    {

        $configurateur->setUser($this->getUser());
        $form = $this->createForm(ConfigurateurType::class, $devis);
        $form->handleRequest($request);

        return $this->render('devis/show.html.twig', [
            // 'societe' => $societe,
            // 'user' => $user,
            'configurateur' => $configurateur,
        ]);
    }
}
