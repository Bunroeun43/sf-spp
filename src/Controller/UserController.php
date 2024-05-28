<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserEditType;
use App\Service\FileUploader;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/user')]
// #[IsGranted('ROLE_ADMIN')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository, FileUploader $fileUploader, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            // on récupère le fichier présent dans le formulaire
            $picture = $form->get('avatar')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $user->setPhoto($fileName);
            }
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère le fichier présent dans le formulaire
            $picture = $form->get('avatar')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $user->setPhoto($fileName);
            }
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    #[Route('/{id}/edit/user', name: 'app_user_edit_user', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function Useredit(Request $request, User $user, UserRepository $userRepository, FileUploader $fileUploader): Response
    {
        // 'user' = $userRepository->findBy(['user' => $this->getUser()]);
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère le fichier présent dans le formulaire
            $picture = $form->get('avatar')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $user->setPhoto($fileName);
            }
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            // 'user' => $userRepository->findBy(['user'=>$this->getUser()]),
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
