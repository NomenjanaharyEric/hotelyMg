<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/utilisateur/modifier/{id}', name: 'app_update_user', methods:["GET","POST"])]
    /**
     * This Methode Allow Us To Update User Information
     *
     * @param User $user
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function update(User $user, Request $request, EntityManagerInterface $manager): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute("app_security_login", [], 301);
        }

        if($this->getUser() !== $user){
            return $this->redirectToRoute("app_home", [], 301);
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $manager->flush();

            $this->addFlash("success", "Information Mis à Jour avec Succès");

            return $this->redirectToRoute("app_show_user", ['id' => $this->getUser()->getId()], 301);
        }

        return $this->render('pages/user/update.html.twig',[
            "form" => $form->createView()
        ]);
    }

    #[Route(path: "/utilisateur/profil/{id}", name: "app_show_user", methods: ["GET"])]
    /**
     * This Methode Allow Us To Show User Information
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        return $this->render("pages/user/show.html.twig",[
            "user" => $user
        ]);
    }
}
