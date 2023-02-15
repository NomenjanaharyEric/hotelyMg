<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route(path: "/deconnexion", name: "app_security_logout", methods:["GET"])]
    public function logout()
    {
        // NOTHING TO DO HERE
    }
}
