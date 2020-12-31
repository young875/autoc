<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\CarsRepository;
use App\Repository\MarquesRepository;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    private $marquesRepository;
    private $wishRepository;
    private $entityManager;

    public function __construct(MarquesRepository $marquesRepository, EntityManagerInterface $entityManager, WishRepository $wishRepository)
    {
        $this->marquesRepository = $marquesRepository;
        $this->wishRepository = $wishRepository;
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/compte/mes-souhaits", name="wish_liste")
     */
    public function index(): Response
    {
        $souhaits = [];
        $marques = $this->marquesRepository->findAll();
        if ($this->getUser()){
            $souhaits = $this->wishRepository->findBy(['user' => $this->getUser()->getId()]);
        }
        return $this->render('wish/index.html.twig', [
            'marques' => $marques,
            'souhaits' => $souhaits,
            'page' => 'wish'
        ]);
    }

    /**
     * @Route("/compte/souhait/{slug}", name="wish_car")
     * @param CarsRepository $carsRepository
     * @param $slug
     * @param Request $request
     * @return Response
     */
    public function add(CarsRepository $carsRepository, $slug, Request $request): Response
    {
        $wish = new Wish();
        $car = $carsRepository->findOneBySlug($slug);
        if (!$car){
            die('nor ok');
        }else{
            $wish->setCar($car);
            $wish->setUser($this->getUser());
            $this->entityManager->persist($wish);
            $this->entityManager->flush();
            $this->addFlash(
            "success", "La voiture à bien été à votre liste des souhaits"
            );
        }

        $marques = $this->marquesRepository->findAll();

        return $this->redirectToRoute('sell_car', ['slug' => $slug]);
    }

    /**
     * @Route("/compte/supprimer-un-souhait/{id}/{slug}", name="wish_remove")
     * @param CarsRepository $carsRepository
     * @param $slug
     * @param Request $request
     * @param Wish $wish
     * @return Response
     */
    public function remonve(CarsRepository $carsRepository, $slug, Request $request, Wish $wish): Response
    {
        $car = $carsRepository->findOneBySlug($slug);
        if (!$car){
            die('nor ok');
        }else{
            $this->entityManager->remove($wish);
            $this->entityManager->flush();

            $this->addFlash(
                "success", "La voiture à bien été à votre liste des souhaits"
            );
        }

        $marques = $this->marquesRepository->findAll();

        return $this->redirectToRoute('wish_liste');
    }

}
