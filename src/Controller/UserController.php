<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserPasswordType;
use App\Form\UserType;
use App\Repository\HotelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/utilisateur/modifier/{id}', name: 'app_update_user', methods:["GET","POST"])]
    #[Security("is_granted('ROLE_USER') and user === currentUser ")]
    /**
     * This Methode Allow Us To Update User Information
     *
     * @param User $user
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function update(User $currentUser, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute("app_security_login", [], 301);
        }

        if($this->getUser() !== $currentUser){
            return $this->redirectToRoute("app_home", [], 301);
        }

        $form = $this->createForm(UserType::class, $currentUser);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            if($hasher->isPasswordValid($currentUser, $form->getData()->getPlainPassword())){
                $user = $form->getData();
                $manager->flush();
    
                return $this->redirectToRoute("app_show_user", ['id' => $this->getUser()->getId()], 301);
            } else {
                $this->addFlash("error", "Mot de passe invalide");
            }

        }

        return $this->render('pages/user/update.html.twig',[
            "form" => $form->createView()
        ]);
    }


    #[Route(path: "/utilisateur/{id}/modifier-mot-de-passe", name: "app_user_change_password", methods:["GET","POST"])]
    #[Security("is_granted('ROLE_USER') and user === currentUser ")]
    /**
     * This Methode Allow Us To Change User Password
     *
     * @param User $user
     * @param Request $request
     * @param UserPasswordHasherInterface $hasher
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function changePassword(User $currentUser, Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(UserPasswordType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            if($hasher->isPasswordValid($currentUser, $form->getData()['plainPassword']))
            {
                $newPassword = $form->getData()['newPassword'];

                $currentUser->setPassword($hasher->hashPassword($currentUser, $newPassword));

                $manager->persist($currentUser);
                $manager->flush();

                return $this->redirectToRoute("app_show_user", ['id' => $currentUser->getId()], 301);
            } else {
                $this->addFlash('error', 'Mot de passe Invalide');
            }
        }

        return $this->render("pages/user/change_password.html.twig",[
            "form" => $form->createView()
        ]);
    }

    #[Route(path: "/utilisateur/profil/{id}", name: "app_show_user", methods: ["GET"])]
    #[Security("is_granted('ROLE_USER') and user === currentUser ")]
    /**
     * This Methode Allow Us To Show User Information
     *
     * @param User $user
     * @return Response
     */
    public function show(User $currentUser, PaginatorInterface $paginator, Request $request): Response
    {
        $hotels = $paginator->paginate(
            $currentUser->getHotels(),
            $request->query->getInt("page", 1),
            6
        );

        return $this->render("pages/user/show.html.twig",[
            "user" => $currentUser,
            "hotels" => $hotels
        ]);
    }
}
