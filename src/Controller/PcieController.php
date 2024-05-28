<?php

namespace App\Controller;

use App\Entity\Pcie;
use App\Form\PcieType;
use App\Repository\PcieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/pcie')]
#[IsGranted('ROLE_ADMIN')]
class PcieController extends AbstractController
{
    #[Route('/', name: 'app_pcie_index', methods: ['GET'])]
    public function index(PcieRepository $pcieRepository): Response
    {
        return $this->render('pcie/index.html.twig', [
            'pcies' => $pcieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_pcie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PcieRepository $pcieRepository): Response
    {
        $pcie = new Pcie();
        $form = $this->createForm(PcieType::class, $pcie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pcieRepository->save($pcie, true);

            return $this->redirectToRoute('app_pcie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pcie/new.html.twig', [
            'pcie' => $pcie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pcie_show', methods: ['GET'])]
    public function show(Pcie $pcie): Response
    {
        return $this->render('pcie/show.html.twig', [
            'pcie' => $pcie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pcie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pcie $pcie, PcieRepository $pcieRepository): Response
    {
        $form = $this->createForm(PcieType::class, $pcie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pcieRepository->save($pcie, true);

            return $this->redirectToRoute('app_pcie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pcie/edit.html.twig', [
            'pcie' => $pcie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pcie_delete', methods: ['POST'])]
    public function delete(Request $request, Pcie $pcie, PcieRepository $pcieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pcie->getId(), $request->request->get('_token'))) {
            $pcieRepository->remove($pcie, true);
        }

        return $this->redirectToRoute('app_pcie_index', [], Response::HTTP_SEE_OTHER);
    }
}
