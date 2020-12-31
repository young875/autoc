<?php

namespace App\Controller\Admin;

use App\Entity\Boites;
use App\Entity\Couleurs;
use App\Entity\Etats;
use App\Form\BoiteType;
use App\Form\CouleurType;
use App\Form\EtatType;
use App\Repository\BoitesRepository;
use App\Repository\CouleursRepository;
use App\Repository\EtatsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CouleurController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/couleur", name="admin_couleur")
     * @param CouleursRepository $repository
     * @return Response
     */
    public function index(CouleursRepository $repository): Response
    {
        $couleurs = $repository->findAll();
        return $this->render('admin/couleur/couleur.html.twig', [
            'couleurs' => $couleurs
        ]);
    }

    /**
     * @Route("/admin/ajouter-une-couleur", name="add_couleur")
     * @param Request $request
     * @return Response
     */
    public function addCouleur(Request $request): Response
    {
        $couleur = new Couleurs();
        $form = $this->createForm(CouleurType::class, $couleur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $this->entityManager->persist($couleur);
            $this->entityManager->flush();
            $this->addFlash(
                "success", "La couleur <strong>{$couleur->getCouleur()} </strong> a bien été enrégistrée!"
            );
        }
        return $this->render('admin/couleur/addcouleur.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/supprimer-une-couleur/{id}", name="del_couleur")
     * @param Couleurs $couleurs
     * @param Request $request
     * @return Response
     */
    public function delCouleur(Couleurs $couleurs,Request $request): Response
    {
        $this->entityManager->remove($couleurs);
        $this->entityManager->flush();
        $this->addFlash(
            "danger", "La couleur <strong>{$couleurs->getCouleur()} </strong> a bien été supprimer!"
        );
        return $this->redirectToRoute('admin_couleur');
    }


    /**
     * @Route("/admin/modifier-une-couleur/{id}", name="update_couleur")
     * @param Request $request
     * @param Couleurs $couleurs
     * @return Response
     */
    public function updateCouleur(Request $request, Couleurs $couleurs): Response
    {
        $form = $this->createForm(CouleurType::class, $couleurs);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->persist($couleurs);
            $this->entityManager->flush();
            $this->addFlash(
                "success", "La couleur <strong>{$couleurs->getCouleur()} </strong> a bien été modifier!"
            );

            return $this->redirectToRoute('admin_couleur');
        }
        return $this->render('admin/couleur/addcouleur.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
