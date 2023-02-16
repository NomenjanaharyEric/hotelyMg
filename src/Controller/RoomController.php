<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    #[Route('/chambre', name: 'app_room', methods: ["GET"])]
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
            6
        );
        return $this->render('pages/room/index.html.twig', [
            "rooms" => $rooms
        ]);
    }

    #[Route(path: "/chambre/information/{id}", name: "app_show_room", methods: ["GET"])]
    /**
     * This Methode Allow Us To Get Room Information
     *
     * @param Room $room
     * @return Response
     */
    public function show(Room $room): Response
    {

        return $this->render("pages/room/show.html.twig", [
            "room" => $room
        ]);
    }

    #[Route(path: "/chambre/nouveau", name: "app_create_room", methods: ["GET", "POST"])]
    /**
     * This Methode Allow Us To Create New Room
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $room = new Room();
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $room = $form->getData();

            $manager->persist($room);
            $manager->flush();

            $this->addFlash("success", "Nouvelle Chambre Créer avec succès");

            return $this->redirectToRoute("app_room", [], 301);
        }

        return $this->render("pages/room/create.html.twig", [
            "form" => $form->createView()
        ]);
    }

    #[Route(path: "/chambre/modifier/{id}", name: "app_update_room", methods: ["GET", "POST"])]
    /**
     * This Methode Allow Us To Update Room Information
     *
     * @param Room $room
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function update(Room $room, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $room = $form->getData();

            $manager->flush();

            $this->addFlash("success","Information du Chambre mis à jour avec succès");

            return $this->redirectToRoute("app_room", [], 301);

        }

        return $this->render("pages/room/update.html.twig", [
            "form" => $form->createView()
        ]);
    }

    #[Route(path: "/chambre/supprimer/{id}", name:"app_delete_room", methods: ["GET"])]
    /**
     * This Methode Allow Us To Delete Room
     *
     * @param Room $room
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Room $room, EntityManagerInterface $manager): Response
    {
        $manager->remove($room);
        $manager->flush();

        $this->addFlash("success", "Chambre supprimer avec succès");

        return $this->redirectToRoute("app_room", [], 301);
    }
}
