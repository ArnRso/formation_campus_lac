<?php

namespace App\Controller;

use App\Form\ProfileType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/users', name: 'user_listing')]
    public function userListing(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('user/users.html.twig', [
            'users' => $users,
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/users/{id}/edit', name: 'user_edit')]
    public function userEdit($id, UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $user = $userRepository->findOneBy(['id' => $id]);
        if (!$user) {
            return $this->redirectToRoute('user_listing');
        }
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('user/userEdit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    #[Route('/users/{id}/delete', name: 'user_delete')]
    public function userDelete(UserRepository $userRepository, EntityManagerInterface $entityManager, $id)
    {
        $user = $userRepository->findOneBy(['id' => $id]);
        if (!$user) {
            return $this->redirectToRoute('user_listing');
        }
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute('user_listing');
    }

    #[Route('/users/{id}/toggle-role/{role}', name: 'user_toggle_role')]
    public function toggleRole(
        $id,
        $role,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    )
    {
        $user = $userRepository->findOneBy(['id' => $id]);

        if (!$user) {
            $this->addFlash('danger', 'Aucun utilisateur trouvé.');
            return $this->redirectToRoute('user_listing');
        }

        $roles = $user->getRoles();

        if (in_array($role, $roles)) {
            // Je veux supprimer le role du tableau $roles
            $key = array_search($role, $roles);
            unset($roles[$key]);
        } else {
            $roles[] = $role;
        }

        // attribuer le nouveau tableau de roles à l'utilisateur (objet)
        $user->setRoles($roles);

        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'Roles modifiés avec succès');
        return $this->redirectToRoute('user_listing');
    }

    #[Route('/profile/edit', name: 'profile_edit')]
    public function editProfile(Request $request, EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('book_listing');
        }

        $form = $this->createForm(ProfileType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('user/profileEdit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
}
