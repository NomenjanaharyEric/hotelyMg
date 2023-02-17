<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/connexion', name: 'app_security_login', methods:["GET","POST"])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('pages/security/login.html.twig',[
            "error" => $authenticationUtils->getLastAuthenticationError()
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route(path: "/deconnexion", name: "app_security_logout", methods:["GET"])]
    public function logout()
    {
        // NOTHING TO DO HERE
    }

    #[Route(path: "/inscription", name: "app_security_register", methods: ["GET","POST"])]
    public function register(Request $request, EntityManagerInterface $manager):Response
    {
        $user = new User();
        $user->setRoles(["ROLE_USER"]);

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute("app_security_login", [], 301);

        }
        return $this->render("pages/security/register.html.twig", [
            "form" => $form->createView()
        ]);
    }
}
