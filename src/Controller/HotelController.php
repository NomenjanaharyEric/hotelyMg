<?php

namespace App\Controller;

use App\Repository\HotelRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HotelController extends AbstractController
{
    #[Route('/hotel', name: 'app_hotel', methods:["GET"])]
    /**
     * Undocumented function
     *
     * @param HotelRepository $hotelRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(HotelRepository $hotelRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $hotels = $paginator->paginate(
            $hotelRepository->findAll(),
            $request->query->getInt("page", 1),
            9
        );
        return $this->render('pages/hotel/index.html.twig', [
            "hotels" => $hotels
        ]);
    }
}
