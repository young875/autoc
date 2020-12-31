<?php

namespace App\Controller\Admin;

use App\Entity\Boites;
use App\Entity\Booking;
use App\Form\BoiteType;
use App\Repository\BoitesRepository;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/reservation", name="admin_booking")
     * @param BookingRepository $repository
     * @return Response
     */
    public function index(BookingRepository $repository): Response
    {
        $bookings = $repository->findAll();
        return $this->render('admin/reservation/reservation.html.twig', [
            'bookings' => $bookings
        ]);
    }

    /**
     * @Route("/admin/voire-une-reservation/{id}", name="show_booking")
     * @param BookingRepository $bookingRepository
     * @param $id
     * @return Response
     */
    public function showBooking(BookingRepository $bookingRepository, $id): Response
    {
        $booking = $bookingRepository->findOneById($id);
        return $this->render('admin/reservation/voir.html.twig', [
            'booking' => $booking
        ]);

    }


    /**
 * @Route("/admin/modifier-une-reservation/{id}", name="booking_traitement")
 * @param Booking $booking
 * @param $id
 * @return Response
 */
    public function sendBooking(Booking $booking,$id): Response
    {
        $booking->setStatut('En cours de traitement');
        $this->entityManager->flush();
        $this->addFlash(
            "success", "La <strong>demande est en cours de traitement </strong>!"
        );
        return $this->redirectToRoute('show_booking' , ['id' => $id]);
    }

    /**
     * @Route("/admin/terminer-une-reservation/{id}", name="booking_close")
     * @param Booking $booking
     * @param $id
     * @return Response
     */
    public function closeBooking(Booking $booking,$id): Response
    {
        $booking->setStatut('Demande traiter et fermer');
        $this->entityManager->flush();
        $this->addFlash(
            "success", "La <strong>demande est fermé </strong>!"
        );
        return $this->redirectToRoute('show_booking' , ['id' => $id]);
    }
}
