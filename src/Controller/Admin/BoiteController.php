<?php

namespace App\Controller\Admin;

use App\Entity\Boites;
use App\Form\BoiteType;
use App\Repository\BoitesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoiteController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/boite", name="admin_boite")
     * @param BoitesRepository $repository
     * @return Response
     */
    public function index(BoitesRepository $repository): Response
    {
        $boites = $repository->findAll();
        return $this->render('admin/boite/boiteindex.html.twig', [
            'boites' => $boites
        ]);
    }

    /**
     * @Route("/admin/ajouter-une-boite", name="add_boite")
     * @param Request $request
     * @return Response
     */
    public function addBoite(Request $request): Response
    {
        $boite = new Boites();
        $form = $this->createForm(BoiteType::class, $boite);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $this->entityManager->persist($boite);
            $this->entityManager->flush();
            $this->addFlash(
                "success", "Le type de boite <strong>{$boite->getBoite()} </strong> a bien été enrégistrée!"
            );
        }
        return $this->render('admin/boite/addboite.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/supprimer-une-boite/{id}", name="del_boite")
     * @param Boites $boite
     * @param Request $request
     * @return Response
     */
    public function delBoite(Boites $boite,Request $request): Response
    {
        $this->entityManager->remove($boite);
        $this->entityManager->flush();
        $this->addFlash(
            "danger", "Le type de boite <strong>{$boite->getBoite()} </strong> a bien été supprimer!"
        );
        return $this->redirectToRoute('admin_boite');
    }


    /**
     * @Route("/admin/modifier-une-boite/{id}", name="update_boite")
     * @param Boites $boite
     * @param Request $request
     * @return Response
     */
    public function updateBoite(Boites $boite,Request $request): Response
    {
        $form = $this->createForm(BoiteType::class, $boite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->persist($boite);
            $this->entityManager->flush();
            $this->addFlash(
                "success", "Le type de boite <strong>{$boite->getBoite()} </strong> a bien été modifier!"
            );

            return $this->redirectToRoute('admin_boite');
        }
        return $this->render('admin/boite/addboite.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
