<?php

namespace App\Controller;

use App\Repository\CarsRepository;
use App\Repository\MarquesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BrandController extends AbstractController
{
    /**
     * @Route("/nos-marques", name="brand")
     * @param MarquesRepository $marquesRepository
     * @return Response
     */
    public function index(MarquesRepository $marquesRepository): Response
    {
        $brands = $marquesRepository->findAll();
        return $this->render('brand/index.html.twig', [
            'brands' => $brands,
            'marques' => $brands,
            'page' => 'brand'
        ]);
    }

    /**
     * @Route("/marques/{slug}", name="showBrand")
     * @param MarquesRepository $marquesRepository
     * @param $slug
     * @param CarsRepository $carsRepository
     * @return Response
     */
    public function showBrand(MarquesRepository $marquesRepository, $slug, CarsRepository $carsRepository): Response
    {
        //$brand = $marquesRepository->findByMarque($slug);
        $brand = $marquesRepository->findOneBySlug($slug);
        $brands = $marquesRepository->findAll();
        if (!$brand){
            $this->redirectToRoute('home');
        }
        $cars = $carsRepository->findByMarques($brand);
        return $this->render('brand/showBand.html.twig', [
            'brand' => $brand,
            'cars' => $cars,
            'marques' => $brands,
            'page' => 'brand'
        ]);
    }
}
