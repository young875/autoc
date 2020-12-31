<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\CarsRepository;
use App\Repository\MarquesRepository;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SellController extends AbstractController
{

    private $entityManager;
    private $marquesRepository;

    public function __construct(EntityManagerInterface $entityManager, MarquesRepository $marquesRepository)
    {
        $this->entityManager = $entityManager;
        $this->marquesRepository = $marquesRepository;
    }


    /**
     * @Route("/voiture/{slug}", name="sell_car")
     * @param CarsRepository $carsRepository
     * @param $slug
     * @param Request $request
     * @param WishRepository $wishRepository
     * @return Response
     */
    public function index(CarsRepository $carsRepository, $slug, Request $request, WishRepository $wishRepository): Response
    {
        $booking = new Booking();
        $existe = '';
        $car = $carsRepository->findOneBySlug($slug);
        if ($this->getUser() && $car){
            $wishList = $wishRepository->findBy(['user' => $this->getUser()->getId()]);
            foreach ($wishList as $wishL){
                $table[] = $wishL->getCar()->getId();
            }
            if (in_array($car->getId(), $table)){
                $existe = 'ok';
            }
        }


        if (!$car){
            die('nor ok');
        }
        $recommended = $carsRepository->findFour($car->getMarques()->getId());
        $txt = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $ref = substr(str_shuffle($txt), 0, 12);

        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $booking = $form->getData();
            $booking->setCar($car);
            if (! is_null($this->getUser())){
                $booking->setEmail($this->getUser()->getUsername());
                $booking->setFirstname($this->getUser()->getFirstname());
                $booking->setLastname($this->getUser()->getLastname());
                $booking->setCivility($this->getUser()->getCivility());
                //set status à vérifier
                $booking->setStatut('En cours de création');
            }

            $this->entityManager->persist($booking);
            $this->entityManager->flush();
            $this->addFlash(
                "success", "Votre réservation à été bien prise en compte. Un de nos agents prendra contact avec vous dans les plus brefs delaits. Nb: Veillez bien verifier l'e-mail avant d'y repondre, il doit être au format xxxx@autoautocar4sale.com. Dans le cas contraire veillez notifier à secure@autocar4sale.com!"
            );
            $this->redirectToRoute('sell_car', ['slug' => $slug]);
        }
        $marques = $this->marquesRepository->findAll();

        return $this->render('sell/index.html.twig', [
            'car' => $car,
            'ref' => $ref,
            'marques' => $marques,
            'recommended' => $recommended,
            'existe' => $existe,
            'form' => $form->createView()
        ]);
    }
}
