<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Notification\ContactNotification;
use App\Repository\CarsRepository;
use App\Repository\MarquesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    private $marquesRepository;

    public function __construct(MarquesRepository $marquesRepository)
    {
        $this->marquesRepository = $marquesRepository;
    }


    /**
     * @Route("/", name="home")
     * @param CarsRepository $carsRepository
     * @return Response
     */
    public function index(CarsRepository $carsRepository): Response
    {
        $marques = $this->marquesRepository->findAll();
        $vehicule = $carsRepository->findIndex();
        return $this->render('home/index.html.twig', [
            'marques' => $marques,
            'cars' => $vehicule,
            'page' => 'home'
        ]);
    }


    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @param ContactNotification $notification
     * @return Response
     */
    public function contact(Request $request, ContactNotification $notification): Response
    {
        //gére le formulaire
        $contact = new Contact();

        $marques = $this->marquesRepository->findAll();

        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $contact = $form->getData();
            $notification->notify($contact);
            $this->addFlash(
                "success", "Votre méssage à bien été envoyer. Un de nos agents prendra contact avec vous dans les plus brefs delaits. Nb: Veillez bien verifier l'e-mail avant d'y repondre, il doit être au format xxxx@autoautocar4sale.com. Dans le cas contraire veillez notifier à secure@autocar4sale.com!"
            );
            $this->redirectToRoute('contact');
        }
        return $this->render('home/contact.html.twig', [
            'form' => $form->createView(),
            'page' => 'contact',
            'marques' => $marques,
            'page' => 'contacts'
        ]);
    }


    /**
     * @Route("/engagement-de-confidentialite", name="confidentialite")
     */
    public function confidentialite(): Response
    {
        $marques = $this->marquesRepository->findAll();
        return $this->render('home/confidentialite.html.twig', [
            'marques' => $marques,
        ]);
    }

    /**
     * @Route("/mentions-legales", name="mentions")
     */
    public function mentions(): Response
    {
        $marques = $this->marquesRepository->findAll();
        return $this->render('home/mentions.html.twig', [
            'marques' => $marques,
        ]);
    }


}
