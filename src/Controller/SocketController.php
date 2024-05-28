<?php

namespace App\Controller;

use App\Entity\Socket;
use App\Form\SocketType;
use App\Repository\SocketRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/socket')]
#[IsGranted('ROLE_ADMIN')]
class SocketController extends AbstractController
{
    #[Route('/', name: 'app_socket_index', methods: ['GET'])]
    public function index(SocketRepository $socketRepository): Response
    {
        return $this->render('socket/index.html.twig', [
            'sockets' => $socketRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_socket_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SocketRepository $socketRepository): Response
    {
        $socket = new Socket();
        $form = $this->createForm(SocketType::class, $socket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $socketRepository->save($socket, true);

            return $this->redirectToRoute('app_socket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('socket/new.html.twig', [
            'socket' => $socket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_socket_show', methods: ['GET'])]
    public function show(Socket $socket): Response
    {
        return $this->render('socket/show.html.twig', [
            'socket' => $socket,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_socket_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Socket $socket, SocketRepository $socketRepository): Response
    {
        $form = $this->createForm(SocketType::class, $socket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $socketRepository->save($socket, true);

            return $this->redirectToRoute('app_socket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('socket/edit.html.twig', [
            'socket' => $socket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_socket_delete', methods: ['POST'])]
    public function delete(Request $request, Socket $socket, SocketRepository $socketRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$socket->getId(), $request->request->get('_token'))) {
            $socketRepository->remove($socket, true);
        }

        return $this->redirectToRoute('app_socket_index', [], Response::HTTP_SEE_OTHER);
    }
}
