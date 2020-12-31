<?php

namespace App\Controller;

use App\Repository\BookingRepository;
use App\Repository\MarquesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountBookingController extends AbstractController
{
    private $marquesRepository;

    public function __construct( MarquesRepository $marquesRepository)
    {
        $this->marquesRepository = $marquesRepository;
    }
    /**
     * @Route("/compte/reservations", name="account_booking")
     * selectionner toutes les reservations
     * @param BookingRepository $bookingRepository
     * @return Response
     */
    public function index(BookingRepository $bookingRepository): Response
    {
        $marques = $this->marquesRepository->findAll();
        $booking = $bookingRepository->findByEmail($this->getUser()->getUsername());

        return $this->render('account_booking/index.html.twig',[
            'marques' => $marques,
            'bookings' => $booking,
        ]);
    }
}
