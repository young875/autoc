<?php

namespace App\Controller\Admin;

use App\Entity\Boites;
use App\Entity\Etats;
use App\Form\BoiteType;
use App\Form\EtatType;
use App\Repository\BoitesRepository;
use App\Repository\EtatsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtatController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/etat", name="admin_etat")
     * @param EtatsRepository $repository
     * @return Response
     */
    public function index(EtatsRepository $repository): Response
    {
        $etats = $repository->findAll();
        return $this->render('admin/etat/etat.html.twig', [
            'etats' => $etats
        ]);
    }

    /**
     * @Route("/admin/ajouter-un-etat", name="add_etat")
     * @param Request $request
     * @return Response
     */
    public function addetat(Request $request): Response
    {
        $etat = new Etats();
        $form = $this->createForm(EtatType::class, $etat);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $this->entityManager->persist($etat);
            $this->entityManager->flush();
            $this->addFlash(
                "success", "L'etat <strong>{$etat->getEtat()} </strong> a bien été enrégistrée!"
            );
        }
        return $this->render('admin/etat/addetat.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/supprimer-un-etat/{id}", name="del_etat")
     * @param Etats $etats
     * @param Request $request
     * @return Response
     */
    public function delBoite(Etats $etats,Request $request): Response
    {
        $this->entityManager->remove($etats);
        $this->entityManager->flush();
        $this->addFlash(
            "danger", "L'etat <strong>{$etats->getEtat()} </strong> a bien été supprimer!"
        );
        return $this->redirectToRoute('admin_etat');
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
