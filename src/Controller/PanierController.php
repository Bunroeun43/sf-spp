<?php

namespace App\Controller;

use App\Entity\CarteMere;
use App\Entity\Configurateur;
use App\Entity\LigneCommande;
use App\Repository\CommandeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function panier(CommandeRepository $commandeRepository): Response
    {
        $panier = $commandeRepository->findOneBy([
            'statut' => 'panier',
            'client' => $this->getUser(),
        ]);
        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
            'panier' => $panier,
        ]);
    }

    #[route('panier/single_produit/{id}', name: 'single_produit', methods: ['GET', 'POST'])]
    public function single_produit(Request $request, Configurateur $configurateur) : response
    {
        $ligneCommande = new LigneCommande();
        $form = $this->createForm(LignecommandeType::class, $ligneCommande);
        $form->handleRequest($request);

        $panier = $commandeRepository->findOneBy([
            'staut' => 'panier',
            'client' => $this->getUser(),
        ]);

        if($form->isSubmitted() && $form->isValid()) {
            $ligneCommande->setProduit($configurateur);
            $lignecommande->setCommande($panier);
            $ligneCommandeRepository->add($ligneCommande, true);
            return $this->redirectToRoute('app_panier', [], Respnse::HTTP_SEE_OTHER);
        }

        return $this->render('panier/single_produit.html.twig', [
            'configurateur' => $configurateur,
            'form' => $form,
            'commande' => $panier,
            'ligne_commande' => $ligneCommande,
            'button_label' => 'Ajouter au panier',
        ]);
    }
}
