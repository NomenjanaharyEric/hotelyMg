<?php

namespace App\Controller;

use App\Repository\RoomRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    #[Route('/room', name: 'app_room', methods: ["GET"])]
    /**
     * This Methode Allow Us To Get All Rooms List with Pagination
     *
     * @param RoomRepository $roomRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(RoomRepository $roomRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $rooms = $paginator->paginate(
            $roomRepository->findAll(),
            $request->query->getInt("page", 1),
            10
        );
        return $this->render('pages/room/index.html.twig', [
            "rooms" => $rooms
        ]);
    }
}
