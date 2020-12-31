<?php

namespace App\Controller;

use App\Repository\MarquesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{

    private $marquesRepository;

    public function __construct(MarquesRepository $marquesRepository)
    {
        $this->marquesRepository = $marquesRepository;
    }

    /**
     * @Route("/compte", name="account")
     */
    public function index(): Response
    {
        $marques = $this->marquesRepository->findAll();
        return $this->render('account/index.html.twig', [
            'marques' => $marques,
            'page' => 'account'
        ]);
    }
}
