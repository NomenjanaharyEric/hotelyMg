<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Form\HotelType;
use App\Repository\HotelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HotelController extends AbstractController
{
    #[Route(path: '/hotel', name: 'app_hotel', methods:["GET"])]
    /**
     * This Methode Allow Us To get Paginate List Of Hotels
     *
     * @param HotelRepository $hotelRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(HotelRepository $hotelRepository, Request $request, PaginatorInterface $paginator): Response
    {
        
        $hotels = $paginator->paginate(
            $hotelRepository->findBy(['user' => $this->getUser()]),
            $request->query->getInt("page", 1),
            9
        );
        return $this->render('pages/hotel/index.html.twig', [
            "hotels" => $hotels
        ]);
    }

    #[Route(path:"/hotel/voir/{id}", name: "app_show_hotel", methods: ["GET"])]
    /**
     * This Methode Allow Us To Get Hotel Information
     *
     * @param Hotel $hotel
     * @return Response
     */
    public function show(Hotel $hotel): Response
    {
        return $this->render("pages/hotel/show.html.twig",[
            "hotel" => $hotel
        ]);
    }

    #[Route(path: "/hotel/nouveau", name: "app_create_hotel", methods: ["GET", "POST"])]
    /**
     * This Methode Allow Us To Create New Hotel
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $hotel = new Hotel();
        $hotel->setUser($this->getUser());

        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $hotel = $form->getData();
            $manager->persist($hotel);
            $manager->flush();

            $this->addFlash("success", "Nouvelle Hotel créer avec succès");

            return $this->redirectToRoute("app_hotel", [], 301);
        }

        return $this->render("pages/hotel/create.html.twig", [
            "form" => $form->createView()
        ]);
    }
    
    #[Route(path: "/hotel/modifier-{id}", name:"app_update_hotel", methods: ["GET","POST"])]
    /**
     * This Methode Allow Us To Update Hotel
     *
     * @param Hotel $hotel
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function update(Hotel $hotel, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $hotel = $form->getData();
            $manager->flush();

            $this->addFlash("success", "L'information de l'hotel a été mis à jour avec succès");

            return $this->redirectToRoute("app_hotel", [], 301);
        }

        return $this->render("pages/hotel/update.html.twig",[
            "form" => $form->createView()
        ]);
    }

    #[Route(path: "/hotel/supprimer/{id}", name:"app_delete_hotel", methods: ["GET"])]
    /**
     * This Methode Allow Us To Delete Hotel
     *
     * @param Hotel $hotel
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Hotel $hotel, EntityManagerInterface $manager): Response
    {
        $manager->remove($hotel);
        $manager->flush();

        $this->addFlash("success", "Hotel supprimer avec succès");

        return $this->redirectToRoute("app_hotel", [], 301);
    }
}
