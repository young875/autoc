<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminHomeController extends AbstractController
{

    /**
     * @Route("/admin", name="admin_home")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/admin/utilisateur", name="admin_user")
     * @param UserRepository $repository
     * @return Response
     */
    public function user(UserRepository $repository): Response
    {
        $users = $repository->findAll();
        return $this->render('admin/user.html.twig',[
            'users' => $users
        ]);
    }

}
