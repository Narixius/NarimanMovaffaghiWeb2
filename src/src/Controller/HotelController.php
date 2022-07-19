<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Form\HotelType;
use App\Repository\HotelRepository;
use App\Service\SearchHotel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/hotel')]
class HotelController extends AbstractController
{
    #[Route('/', name: 'app_hotel_index', methods: ['GET'])]
    public function index(HotelRepository $hotelRepository, Request $request, SearchHotel $searchHotel): Response
    {
        return $this->render('hotel/index.html.twig', [
            'hotels' => $hotelRepository->findAll(),
        ]);
    }
    #[Route('/search', name: 'app_hotel_search', methods: ['GET'])]
    public function search(HotelRepository $hotelRepository, Request $request, SearchHotel $searchHotel): Response
    {
        $q = $request->query->get('q');

        if($q){
            $hotels = $searchHotel->search($q);
        }else{
            $hotels = $hotelRepository->findAll();
        }

        return $this->render('hotel/index.html.twig', [
            'hotels' => $hotels,
            'query' => $q
        ]);
    }

    #[Route('/new', name: 'app_hotel_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_HOTEL_OWNER')]
    public function new(Request $request, HotelRepository $hotelRepository): Response
    {
        $hotel = new Hotel();
        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hotelRepository->add($hotel, true);

            return $this->redirectToRoute('app_hotel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hotel/new.html.twig', [
            'hotel' => $hotel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hotel_show', methods: ['GET'])]
    public function show(Hotel $hotel): Response
    {
        return $this->render('hotel/show.html.twig', [
            'hotel' => $hotel,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_hotel_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_HOTEL_OWNER')]
    #[IsGranted('HOTEL_EDIT', subject: 'hotel')]
    public function edit(Request $request, Hotel $hotel, HotelRepository $hotelRepository): Response
    {
        $this->denyAccessUnlessGranted('HOTEL_EDIT', $hotel);

        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hotelRepository->add($hotel, true);

            return $this->redirectToRoute('app_hotel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hotel/edit.html.twig', [
            'hotel' => $hotel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hotel_delete', methods: ['POST'])]
    #[IsGranted('ROLE_HOTEL_OWNER')]
    #[IsGranted('HOTEL_DELETE', subject: 'hotel')]
    public function delete(Request $request, Hotel $hotel, HotelRepository $hotelRepository): Response
    {

        if ($this->isCsrfTokenValid('delete'.$hotel->getId(), $request->request->get('_token'))) {
            $hotelRepository->remove($hotel, true);
        }

        return $this->redirectToRoute('app_hotel_index', [], Response::HTTP_SEE_OTHER);
    }
}
