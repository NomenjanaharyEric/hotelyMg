<?php

namespace App\Controller;

use App\Repository\HotelRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods:['GET'])]
    public function index(HotelRepository $hotelRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $hotels = $paginator->paginate(
            $hotelRepository->findBy(['isPublished' => true]),
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('pages/home/index.html.twig',[
            "hotels" => $hotels
        ]);
    }
}
