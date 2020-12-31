<?php

namespace App\Controller\Admin;

use App\Entity\Boites;
use App\Entity\Carburations;
use App\Form\BoiteType;
use App\Form\CarburationType;
use App\Repository\BoitesRepository;
use App\Repository\CarburationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarburationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/carburation", name="admin_carburation")
     * @param CarburationsRepository $repository
     * @return Response
     */
    public function index(CarburationsRepository $repository): Response
    {
        $carburations = $repository->findAll();
        return $this->render('admin/carburation/carburation.html.twig', [
            'carburations' => $carburations
        ]);
    }

    /**
     * @Route("/admin/ajouter-une-carburation", name="add_carburation")
     * @param Request $request
     * @return Response
     */
    public function addCarburation(Request $request): Response
    {
        $carburation = new Carburations();
        $form = $this->createForm(CarburationType::class, $carburation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $this->entityManager->persist($carburation);
            $this->entityManager->flush();
            $this->addFlash(
                "success", "Le type de carburation <strong>{$carburation->getCarburation()} </strong> a bien été enrégistrée!"
            );
        }
        return $this->render('admin/carburation/addcarburation.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/supprimer-une-carburation/{id}", name="del_carburation")
     * @param Carburations $carburations
     * @param Request $request
     * @return Response
     */
    public function delBoite(Carburations $carburations,Request $request): Response
    {
        $this->entityManager->remove($carburations);
        $this->entityManager->flush();
        $this->addFlash(
            "danger", "Le type de carburation <strong>{$carburations->getCarburation()} </strong> a bien été supprimer!"
        );
        return $this->redirectToRoute('admin_carburation');
    }


    /**
     * @Route("/admin/modifier-une-carburation/{id}", name="update_carburation")
     * @param Carburations $carburations
     * @param Request $request
     * @return Response
     */
    public function updateCarburation(Carburations $carburations,Request $request): Response
    {
        $form = $this->createForm(CarburationType::class, $carburations);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->persist($carburations);
            $this->entityManager->flush();
            $this->addFlash(
                "success", "Le type de carburation <strong>{$carburations->getCarburation()} </strong> a bien été modifier!"
            );

            return $this->redirectToRoute('admin_carburation');
        }
        return $this->render('admin/carburation/addcarburation.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
