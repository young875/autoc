<?php

namespace App\Controller\Admin;

use App\Entity\Boites;
use App\Entity\Cars;
use App\Entity\Etats;
use App\Form\BoiteType;
use App\Form\CarType;
use App\Form\EtatType;
use App\Repository\BoitesRepository;
use App\Repository\CarsRepository;
use App\Repository\EtatsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/car", name="admin_car")
     * @param CarsRepository $repository
     * @return Response
     */
    public function index(CarsRepository $repository): Response
    {
        $cars = $repository->findAll();
        return $this->render('admin/car/car.html.twig', [
            'cars' => $cars
        ]);
    }

    /**
     * @Route("/admin/ajouter-une-voiture", name="add_car")
     * @param Request $request
     * @return Response
     */
    public function addCar(Request $request): Response
    {
        $car = new Cars();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            foreach ($car->getImages() as $image ){
                $image->setCars($car);
                $this->entityManager->persist($image);
            }
            $this->entityManager->persist($car);
            $this->entityManager->flush();
            $this->addFlash(
                "success", "Le véhicule <strong>{$car->getSlug()} </strong> a bien été enrégistrée!"
            );
            $this->redirectToRoute('admin_car');
        }
        return $this->render('admin/car/AddCar.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/publier-une-voiture/{id}", name="send_car")
     * @param Cars $cars
     * @param Request $request
     * @return Response
     */
    public function sendCar(Cars $cars,Request $request): Response
    {
        $cars->setPublie(1);
        $this->entityManager->flush();
        $this->addFlash(
            "success", "Le véhicule <strong>{$cars->getSlug()} </strong> a bien été publier sur le site!"
        );
        return $this->redirectToRoute('admin_car');
    }

    /**
     * @Route("/admin/retirer-une-voiture/{id}", name="remove_car")
     * @param Cars $cars
     * @param Request $request
     * @return Response
     */
    public function removeCar(Cars $cars,Request $request): Response
    {
        $cars->setPublie(0);
        $this->entityManager->flush();
        $this->addFlash(
            "warning", "Le véhicule <strong>{$cars->getSlug()} </strong> a bien été retiré sur le site!"
        );
        return $this->redirectToRoute('admin_car');
    }


    /**
     * @Route("/admin/modifier-un-etat/{id}", name="update_etat")
     * @param Etats $etats
     * @param Request $request
     * @return Response
     */
    public function updateBoite(Etats $etats,Request $request): Response
    {
        $form = $this->createForm(EtatType::class, $etats);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->persist($etats);
            $this->entityManager->flush();
            $this->addFlash(
                "success", "Le type de boite <strong>{$etats->getEtat()} </strong> a bien été modifier!"
            );

            return $this->redirectToRoute('admin_etat');
        }
        return $this->render('admin/etat/addetat.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
