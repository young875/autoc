<?php

namespace App\Controller\Admin;

use App\Entity\Boites;
use App\Entity\Etats;
use App\Entity\Marques;
use App\Form\BoiteType;
use App\Form\EtatType;
use App\Form\MarqueType;
use App\Repository\BoitesRepository;
use App\Repository\EtatsRepository;
use App\Repository\MarquesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarqueController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/marques", name="admin_brands")
     * @param MarquesRepository $repository
     * @return Response
     */
    public function index(MarquesRepository $repository): Response
    {
        $marques = $repository->findAll();
        return $this->render('admin/marque/marque.html.twig', [
            'marques' => $marques
        ]);
    }

    /**
     * @Route("/admin/ajouter-une-marque", name="add_brand")
     * @param Request $request
     * @return Response
     */
    public function addBrand(Request $request): Response
    {
        $marque = new Marques();
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $this->entityManager->persist($marque);
            $this->entityManager->flush();
            $this->addFlash(
                "success", "La marque <strong>{$marque->getMarque()} </strong> a bien été enrégistrée!"
            );
        }
        return $this->render('admin/marque/addMarque.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/supprimer-une-marque/{id}", name="del_brand")
     * @param Marques $marques
     * @param Request $request
     * @return Response
     */
    public function delBrand(Marques $marques,Request $request): Response
    {
        $this->entityManager->remove($marques);
        $this->entityManager->flush();
        $this->addFlash(
            "danger", "La marque <strong>{$marques->getMarque()} </strong> a bien été supprimer!"
        );
        return $this->redirectToRoute('admin_brands');
    }


    /**
     * @Route("/admin/modifier-une-marque/{id}", name="update_brand")
     * @param Marques $marques
     * @param Request $request
     * @return Response
     */
    public function updateBoite(Marques $marques,Request $request): Response
    {
        $form = $this->createForm(MarqueType::class, $marques);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->persist($marques);
            $this->entityManager->flush();
            $this->addFlash(
                "success", "La marque <strong>{$marques->getMarque()} </strong> a bien été modifier!"
            );

            return $this->redirectToRoute('admin_brands');
        }
        return $this->render('admin/marque/addMarque.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
